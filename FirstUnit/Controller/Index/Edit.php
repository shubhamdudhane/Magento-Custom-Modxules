<?php
namespace Learning\FirstUnit\Controller\Index;
 
class Edit extends \Magento\Framework\App\Action\Action
{
     protected $_pageFactory;
     protected $_request;
     protected $_postLoader;
    
    /* Constructor
     *
     * @param Context $context
     * @param UrlInterface $url
     * @param PageFactory $resultPageFactory
     * @param Http $request
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request
    ) {
         $this->_pageFactory = $pageFactory;
         $this->_request = $request;
         return parent::__construct($context);
    }
    
    /**
     * form edit controller action
     * @return _pageFactory
     */
    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
