<?php
namespace Handycraft\ProductAttributes\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * Set factory
     *
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
    private $attributeSetFactory;
    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory             $eavSetupFactory
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
    ) {
        echo "shubham";
        exit;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * Function install
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $defaultAttributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);


        /********* BEGIN: Create Default Attribute SET ********* */

        /** @var \Magento\Eav\Model\Entity\Attribute\Set $attributeSet */
        $attributeSetName = "My Attribute Set";
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setEntityTypeId($entityTypeId)->load($attributeSetName, 'attribute_set_name');
        if ($attributeSet->getId()) {
            throw new AlreadyExistsException(__('Attribute Set already exists.'));
        }
        $attributeSet->setAttributeSetName($attributeSetName)->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($defaultAttributeSetId)->save();

        // Get the attribute group
        $attributeGroupId = $eavSetup->getAttributeGroupId(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            'General'
        );
        /********* END ********* */




        /********* BEGIN: Add TEXT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'length',
            [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Length',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'length',
            '1' // Sort Order
        );
        /********* END ********* */





        /********* BEGIN: Add TEXTAREA attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'width',
            [
                'type' => 'text',
                'input' => 'text',
                'label' => 'Width',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'width',
            '2' // Sort Order
        );
        /********* END ********* */


        /********* BEGIN: Add DROPDOWN/SELECT attribute ********* */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'height',
            [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Height',
                'required' => false,
                'user_defined' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'source' => ''
            ]
        );
        $eavSetup->addAttributeToGroup(
            \Magento\Catalog\Model\Product::ENTITY,
            $attributeSet->getId(),
            $attributeGroupId,
            'height',
            '3' // Sort Order
        );
        /********* END ********* */

        $setup->endSetup();


    }
}