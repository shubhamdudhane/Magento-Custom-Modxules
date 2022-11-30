<?php

namespace Shippingapi\Shipping\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Setup\Exception;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;
use Magento\Checkout\Model\Cart;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Encryption\EncryptorInterface;

class Express extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'shiprocket';

    /**
     * @var ResultFactory
     */
    protected $rateResultFactory;
    /**
     * @var MethodFactory
     */
    protected $_rateMethodFactory;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var Curl
     */
    protected $curl;
    /**
     * @var json
     */
    protected $json;
    /**
     * @var _encryptor
     */
    protected $_encryptor;
    /**
     * Store pickup zipcode
     * @var XML_STORE_PICKUP_DELIEVERY_ZIPCODE
     */
    const XML_STORE_PICKUP_DELIEVERY_ZIPCODE = 'general/store_information/postcode';
    /**
     * ShipRocket Api endpoint
     * @var XML_SHIP_LOGIN_POST_URL_API_URL
     */
    const XML_SHIP_LOGIN_POST_URL_API_URL = 'carriers/shiprocket/shiploginapiurl';
    /**
     * ShipRocket Api Price calculation endpoint
     * @var XML_SHIP_PRICE_CALCULATE_API_URL
     */
    const XML_SHIP_PRICE_CALCULATE_API_URL = 'carriers/shiprocket/pricecalculatorapiurl';
    /**
     * ShipRocket Api Username
     * @var XML_SHIP_PRICE_CALCULATE_API_URL
     */
    const XML_SHIP_API_LOGIN_CURRIOR_EMAIL = 'carriers/shiprocket/shiploginapiemail';
    /**
     * ShipRocket Api Password
     * @var XML_SHIP_API_LOGIN_CURRIOR_PASSWORD
     */
    const XML_SHIP_API_LOGIN_CURRIOR_PASSWORD = 'carriers/shiprocket/shiploginpassword';

    /**
     * Construct
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param Encryptor $encryptor
     * @param Curl $curl
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory         $rateErrorFactory,
        LoggerInterface      $logger,
        ResultFactory        $rateResultFactory,
        MethodFactory        $rateMethodFactory,
        Curl $curl,
        Json $json,
        EncryptorInterface $encryptor,
        Cart $cart,
        array                $data = []
    ) {
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->curl = $curl;
        $this->json = $json;
        $this->_encryptor = $encryptor;
        $this->cart = $cart;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * Get Store Config value
     * @param string $fileld
     * @return mixed
     */
    public function getGeneralConfig($field)
    {
        return $this->scopeConfig->getValue($field);
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['shiprocket' => $this->getConfigData('name')];
    }

    /**
     * collect Shipping rates
     * @param RateRequest $request
     * @return bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        #Get login Authentication token
        $token = $this->generateToken();
        $rates = $this->getRate($token);
        // $ratess = $rate->available_courier_companies[0]->rate;
        $rates = round($rates);

        if (!empty($rates)) {
            $result = $this->rateResultFactory->create();

            $method = $this->rateMethodFactory->create();
            $method->setCarrier('shiprocket');
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod('shiprocket');
            $method->setMethodTitle($this->getConfigData('name'));

            $method->setPrice($rates);
            $method->setCost($rates);

            $result->append($method);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Generate token
     * @return null
     */
    protected function generateToken()
    {
        $loginApi = $this->getGeneralConfig(self::XML_SHIP_LOGIN_POST_URL_API_URL);
        $apiUserName = $this->getGeneralConfig(self::XML_SHIP_API_LOGIN_CURRIOR_EMAIL);
        $apiPasswords = $this->getGeneralConfig(self::XML_SHIP_API_LOGIN_CURRIOR_PASSWORD);
        $apiPassword = $this->_encryptor->decrypt($apiPasswords);

        $arr = [
            "email" => $apiUserName,
            "password" => $apiPassword,
        ];

        $login_data = json_encode($arr);
        try {
            $this->curl->addHeader("Content-Type", "application/json");
            $this->curl->post($loginApi, $login_data);
            $result = $this->curl->getBody();
            $res = json_decode($result);
            return $res->token;
        } catch (Exception $ex) {
            return null;
        }
    }

    /**
     * getRate calculating price for shipping rate with ShipRocket Api Price Calculation
     * @param $token
     * @return int
     */
    protected function getRate($token)
    {
        $getRateAPI = $this->getGeneralConfig(self::XML_SHIP_PRICE_CALCULATE_API_URL);
        $pickupdelcode= $this->getGeneralConfig(self::XML_STORE_PICKUP_DELIEVERY_ZIPCODE);
        $deliveryPostcode = $this->cart->getQuote()->getShippingAddress()->getPostcode();

        $items = $this->cart->getQuote()->getAllItems();
        $weight = $breadth = $height = $length = 0;

        foreach($items as $item) {
            $weight += ($item->getWeight() * $item->getQty()) ;
            $productID = $item->getProductId();
            $product = $item->getProduct();
            $productFull = $product->load($productID);
            $breadth += ($productFull->getWidth() * $item->getQty());
            $height += ($productFull->getHeight() * $item->getQty());
            $length += ($productFull->getLength() * $item->getQty());
        }

        $arra = [
            "pickup_postcode" => $pickupdelcode,
            "delivery_postcode" => $deliveryPostcode,
            "weight" => $weight,
            "length" => $length,
            "breadth" => $breadth,
            "height" => $height,
            "cod" => '0',
        ];

        $datas = http_build_query($arra);
        $apiUrl = $getRateAPI.'?'.$datas;

        try {
            $this->curl->addHeader("Content-Type", "application/json");
            $this->curl->addHeader('Authorization','Bearer '.$token);
            $this->curl->get($apiUrl);
            $response = json_decode($this->curl->getBody());
            $returnRate = 25;
            if(isset($response->status) && !empty($response->status) && $response->status == '200') {
                $data = $response->data->available_courier_companies[0];
                if(isset($data->rate) && !empty($data->rate))
                    $returnRate = $data->rate;
                return $returnRate;
            }
            return $returnRate;
        } catch (Exception $exception) {
            return 25;
        }
    }
}