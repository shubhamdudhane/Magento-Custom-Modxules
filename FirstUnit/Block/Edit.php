<?php
namespace Learning\FirstUnit\Block;

class Edit extends \Magento\Framework\View\Element\Template
{
    protected $_pageFactory;
    protected $_postLoader;
    
    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $PageFactory
     * @param PostFactory $postLoader
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Learning\FirstUnit\Model\PostFactory $postLoader,
        array $data = []
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_postLoader = $postLoader;
        return parent::__construct($context, $data);
    }
    
    /**
     * submiting form action on this URL.
     * @return getUrl
     */
    public function getFormAction()
    {
        return $this->getUrl('firstunit/index/submit', ['_secure' => false]);
    }
    
    /**
     * from data edting action with getRequest & getParam.
     * @return model
     */
    public function getEditData()
    {
         $id = $this->getRequest()->getParam('id');
         $model = $this->_postLoader->create();
        return $model->load($id);
    }
}
