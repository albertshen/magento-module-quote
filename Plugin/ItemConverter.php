<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Plugin;

/**
 * ItemConverter
 */
class ItemConverter
{
    
    /**
     * Filter collection by specified website, customer group, coupon code, date.
     * Filter collection to use only active rules.
     * Involved sorting by sort_order column.
     *
     * @param \Magento\Quote\Model\Cart\Totals\ItemConverter $itemConverter
     * @param \Magento\Quote\Api\Data\TotalsItemInterface $result
     * @param \Magento\Quote\Model\Quote\Item $item
     * @throws \Exception
     * @return \Magento\Quote\Api\Data\TotalsItemInterface
     */
    public function afterModelToDataObject(
        \Magento\Quote\Model\Cart\Totals\ItemConverter $itemConverter,
        $result,
        $item
    ) {

        $result->getExtensionAttributes()->setProductId($item->getProductId());
        return $result;
    }

}
