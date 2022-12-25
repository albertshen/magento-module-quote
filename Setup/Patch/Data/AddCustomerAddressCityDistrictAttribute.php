<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Creates a customer attribute for managing a customer's external system ID
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class AddCustomerAddressCityDistrictAttribute implements DataPatchInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
 
    /**
     * @var QuoteSetupFactory
     */
    private $quoteSetupFactory;
 
    /**
     * @var SalesSetup
     */
    private $salesSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param EavSetupFactory $eavSetupFactory
     * @param QuoteSetupFactory $quoteSetupFactory
     * @param salesSetupFactory $salesSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        QuoteSetupFactory $quoteSetupFactory,
        salesSetupFactory $salesSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {

        // /** @var EavSetup $eavSetup */
        // $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
 
        /** @var QuoteSetup $quoteSetup */
        $quoteSetup = $this->quoteSetupFactory->create(['setup' => $setup]);
 
        // /** @var SalesSetup $salesSetup */
        // $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);

        // Add customer attribute with settings
        $quoteSetup->addAttribute(
            'quote_address',
            'city',
            [
                'type' => 'static',
                'label' => 'City',
                'input' => 'text',
                'required' => false,
                'sort_order' => 101,
                'position' => 101,
                'system' => 0,
            ]
        );
        $quoteSetup->addAttribute(
            'quote_address',
            'city_id',
            [
                'type' => 'static',
                'label' => 'City',
                'input' => 'hidden',
                'required' => false,
                'sort_order' => 101,
                'position' => 101,
                'system' => 0,
            ]
        );
        $quoteSetup->addAttribute(
            'quote_address',
            'district',
            [
                'type' => 'static',
                'label' => 'District',
                'input' => 'text',
                'required' => false,
                'sort_order' => 102,
                'position' => 102,
                'system' => 0,
            ]
        );
        $quoteSetup->addAttribute(
            'quote_address',
            'district_id',
            [
                'type' => 'static',
                'label' => 'District',
                'input' => 'hidden',
                'required' => false,
                'sort_order' => 102,
                'position' => 102,
                'system' => 0,
            ]
        );
        $entity = $quoteSetup->getEavConfig()->getEntityType('quote_address');
        $attributeSetId = $entity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $cityIdAttribute = $quoteSetup->getEavConfig()->getAttribute('quote_address', 'city_id');

        $cityIdAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId
        ]);

        // Save attribute using its resource model
        $cityIdAttribute->save();


        $districtAttribute = $quoteSetup->getEavConfig()->getAttribute('quote_address', 'district');

        $districtAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId
        ]);

        // Save attribute using its resource model
        $districtAttribute->save();


        $districtIdAttribute = $quoteSetup->getEavConfig()->getAttribute('quote_address', 'district_id');

        $districtIdAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId
        ]);

        // Save attribute using its resource model
        $districtIdAttribute->save();

        return $this;

    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

}
