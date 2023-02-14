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
     * Add mine cart item.
     *
     * @param int $customerId
     * @param int $productId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addMineItem($customerId, $productId);

    /**
     * Add guest cart item.
     *
     * @param string $guestToken
     * @param int $productId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addGuestItem($guestToken, $productId);
}
