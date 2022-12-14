<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Learning\FirstUnit\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderplaceSms implements ObserverInterface
{
    
    const XML_API_VALUES = 'sms/smsgeneral/apikey';
    const XML_SENDERNAME_VALUES = 'sms/smsgeneral/sendername';
    const XML_ORDER_MESSAGE_VALUES = 'sms/smsgeneral/order_message_template';
    const XML_URL_VALUES = 'sms/smsgeneral/url';
    const XML_URL_ADMIN_NUM_VALUES = 'sms/smsgeneral/adminnumber';
    const XML_URL_MULTISELCT_VALUES = 'sms/smsgeneral/vendor_multiselect';
    protected $scopeConfig;
    
    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    protected $_curl;
    protected $data;

    public function __construct(
        \Learning\FirstUnit\Helper\Data $data,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_curl = $curl;
        $this->data = $data;
    }
    public function getConfigValue($path)
    {
           //fetch config value using $path
           // return store config value
           return $this->scopeConfig->getValue($path);
    }

    public function execute(Observer $observer)
    {

        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();
        $Ordersms = $this->getConfigValue(self::XML_URL_MULTISELCT_VALUES);
        $ordersmscondition =  $Ordersms['Order_place_Sms'];

        if ($ordersmscondition) {

            $mess = ltrim($order->getIncrementId(), "0");
            $messages = $this->getConfigValue(self::XML_ORDER_MESSAGE_VALUES);
            $messss = str_replace("{{order_id}}", $mess, $messages);
            $message = rawurlencode($messages);
            $numbers = [$order->getBillingAddress()->getTelephone()];

        // Send the POST request with cURL
            $data->sendRequest($message, $numbers, 'Order_place_Sms');
        }
    }
}
