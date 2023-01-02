<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Plugin;

use Magento\Quote\Model\Quote\Address;

/**
 * Rule Collection
 */
class RuleCollection
{

    /**
     *
     */
    public function __construct(
    ) {
    }

    /**
     * Filter collection by specified website, customer group, coupon code, date.
     * Filter collection to use only active rules.
     * Involved sorting by sort_order column.
     *
     * @param Magento\SalesRule\Model\ResourceModel\Rule\Collection $collection
     * @param Magento\SalesRule\Model\ResourceModel\Rule\Collection $result
     * @param int $websiteId
     * @param int $customerGroupId
     * @param string $couponCode
     * @param string|null $now
     * @param Address $address allow extensions to further filter out rules based on quote address
     * @throws \Zend_Db_Select_Exception
     * @return Magento\SalesRule\Model\ResourceModel\Rule\Collection
     */
    public function afterSetValidationFilter(
        \Magento\SalesRule\Model\ResourceModel\Rule\Collection $collection,
        $result,
        $websiteId,
        $customerGroupId,
        $couponCode = '',
        $now = null,
        Address $address = null
    ) {
        //$collection->addFieldToFilter('rule_id', ['neq' => 3]);
        return $result;
    }

}
