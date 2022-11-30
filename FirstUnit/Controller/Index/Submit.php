<?php

namespace Learning\FirstUnit\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;
use Learning\FirstUnit\Model\PostFactory;

class Submit extends Action
{
    protected $resultPageFactory;
    protected $postFactory;
    private $url;
    
    /* Constructor
     *
     * @param Context $context
     * @param UrlInterface $url
     * @param PageFactory $resultPageFactory
     * @param PostFactory $PostFactory
    */
    public function __construct(
        UrlInterface $url,
        Context $context,
        PageFactory $resultPageFactory,
        PostFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
        $this->url = $url;
        parent::__construct($context);
    }
    
    /**
     * editing and updating form action on same page & give result on layout page
     * @return $data
     */
    public function execute()
    {
            $data = (array)$this->getRequest()->getPost();
            $model = $this->postFactory->create();
        if (isset($data['id']) && empty($data['id'])) {
                
                $model->load($data['id']);
                $model->setFullNames($data['full_names']);
                $model->setDob($data['dob']);
                $model->setGender($data['gender']);
                $model->setPostalAddress($data['postal_address']);
                $model->setEmail($data['email']);
                $model->setContactNumber($data['contact_number']);
                $model->setDescription($data['description']);
                $model->save();
                $this->messageManager->addSuccessMessage(__("Data Inserted Successfully."));
        } else {
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Data Updated Successfully."));
        }

    /**
     * redirecting on main index.php url
     * @return $resultRedirect
    */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->url->getUrl('firstunit/index/index'));
        return $resultRedirect;
    }
}
