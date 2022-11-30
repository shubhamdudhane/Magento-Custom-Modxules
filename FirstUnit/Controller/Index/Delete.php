<?php
 
namespace Learning\FirstUnit\Controller\Index;
 
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Learning\FirstUnit\Model\PostFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
 
class Delete extends Action
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
        Context $context,
        UrlInterface $url,
        PageFactory $resultPageFactory,
        PostFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
        $this->url = $url;
        parent::__construct($context);
    }
    
    /**
     * Deleting data from database table getRequest & getParram
     * @return array[]
     */
    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getParams();
            if ($data) {
                $model = $this->postFactory->create()->load($data['id']);
                $model->delete();
                $this->messageManager->addSuccessMessage(__("Record Delete Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t delete record, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->url->getUrl('firstunit/index/index'));
        return $resultRedirect;
    }
}
