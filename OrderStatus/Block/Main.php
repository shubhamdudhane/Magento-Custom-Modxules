<?php
namespace SRTechnologies\OrderStatus\Block;

class Main extends \Magento\Framework\View\Element\Template
{    
   
    protected $_productCollectionFactory;
    protected $_orderCollectionFactory;
    protected $product;
        
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Catalog\Model\ProductFactory $product,        
        array $data = []
    )
    { 

        $this->_orderCollectionFactory = $orderCollectionFactory;   
        $this->_productCollectionFactory = $productCollectionFactory; 
        $this->product = $product;   
        parent::__construct($context, $data);
    }
    
   
    public function getOrderCollection() 
    {
         $collection = $this->_orderCollectionFactory->create()
             ->addAttributeToSelect('*')
             ->setOrder('created_at','desc');
             
        return $collection;
    }

     public function getProduct($id)
    {
        return $this->product->create()->load($id);
    }

}