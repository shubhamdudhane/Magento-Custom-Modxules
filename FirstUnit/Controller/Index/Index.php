<?php

namespace Learning\FirstUnit\Controller\Index;

use \Magento\Framework\App\Action\HttpGetActionInterface;
use \Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface 
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $PostFactory;

    /**
     * @param PageFactory $resultPageFactory
     * @param PostFactory $PostFactory
     */
    public function __construct(PageFactory $resultPageFactory,
    \Learning\FirstUnit\Model\PostFactory $PostFactory 
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->PostFactory = $PostFactory;
    }

    /**
     * index layout controller action
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}