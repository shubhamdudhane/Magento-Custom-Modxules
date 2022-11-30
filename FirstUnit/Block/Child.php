<?php
namespace Learning\FirstUnit\Block;

use \Magento\Framework\View\Element\Template;

class Child extends Template
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param array $data
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = [],
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }
     /**
      * testing child class with parent class here
      * @return the name.
      */
    public function getMyname()
    {
        return "shubham";
    }
}
