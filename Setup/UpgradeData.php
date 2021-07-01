<?php
/**
 * Copyright © 2016 SW-THEMES. All rights reserved.
 */

namespace Lovevox\CatalogAttributes\Setup;

use Magento\Catalog\Model\Category\AttributeRepository;
use Magento\Eav\Model\Attribute;
use Magento\Eav\Model\Entity\Attribute\Backend\Datetime;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;
    private $eavSetupFactory;

    private $objectManager;

    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(CategorySetupFactory $categorySetupFactory, EavSetupFactory $eavSetupFactory, \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->categorySetupFactory = $categorySetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        /* cataglog attributes */
        $settingAttributes = [
            'color_sync' => [
                'type' => 'int',
                'label' => 'Relate Product Color Sync',
                'input' => 'select',
                'source' => Boolean::class,
                'required' => false,
                'sort_order' => 40,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        ];
        foreach ($settingAttributes as $item => $data) {
            $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, $item, $data);
        }
    }
}
