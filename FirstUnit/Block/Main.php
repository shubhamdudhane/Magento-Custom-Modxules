<?php
namespace Learning\FirstUnit\Block;

use \Magento\Framework\View\Element\Template;

class Main extends Template
{
   const XML_VALUE = 'helloworld/general/name';
   const XML_PATH_GENERAL_EMAIL = 'trans_email/ident_general/email';
   const XML_PATH_SUPPORT_EMAIL = 'trans_email/ident_support/email';
   const XML_PATH_CUSTOM_A_EMAIL = 'trans_email/ident_custom1/emai';
   const XML_PATH_CUSTOM_B_EMAIL = 'trans_email/ident_custom2/email';
   protected $scopeConfig;
   protected $collectionFactory;
   protected $_productRepository;
   protected $PostFactory;
     /* Constructor
     *
     * @param Context $context
     * @param array $data
     * @param ScopeConfigInterface $scopeConfig
     * @param collectionFactory $collectionFactory
     * @param productRepository $productRepository
     * @param PostFactory $PostFactory
    */
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        array $data = [],
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ResourceModel\Product\collectionFactory $collectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Learning\FirstUnit\Model\PostFactory $PostFactory
    ){        
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->collectionFactory = $collectionFactory;
        $this->_productRepository = $productRepository;
        $this->PostFactory = $PostFactory;
    }

   /**
     * Prints the information scopeConfig
     * @return scopeConfig for getting value.
    */
    public function getGeneralConfig($field)
    {
        return $this->scopeConfig->getValue($field);
    }

    /**
     * loading table with featured product attribute and its value 1
     * @return collection to layout file
    */
    public function getProductCollection()
    {
        $collection = $this->collectionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('featured_product', '1')
            ->load();
        return $collection;
    }

    /**
     * fetching table data with PostFactory
     * @return newsCollection to layout file
    */
    public function getModelData(){
        $pag = $this->PostFactory->create();
        $newsCollection = $pag->getCollection();
       return $newsCollection;
   }
    /**
     * getting Product Id from database table
     * @return to layout file
    */
    public function getProduct($id){
        $id = 'entity_id';
        $sku = 'sku';
        $product= $this->_productRepository->create()->load($id)
                      ->getAttributeText('sku');
        return $product;
    }
    /**
     * Prints the information collectionFactory
     * @return collectionFactory
    */
    public function getMembers(){

        return $collection = $this->collectionFactory;
    }
}