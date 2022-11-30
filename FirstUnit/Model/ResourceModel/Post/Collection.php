<?php
namespace Learning\FirstUnit\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'all_catalog_product';
    protected $_eventObject = 'all_catalog_product_object';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Learning\FirstUnit\Model\Post', 'Learning\FirstUnit\Model\ResourceModel\Post');
    }
}
