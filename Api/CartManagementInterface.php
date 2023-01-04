<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api;

/**
 * Interface for managing cart.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartManagementInterface
{
    /**
     * Add cart item.
     *
     * @param int $customerId
     * @param int $productId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addItem($customerId, $productId);
}
