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
     * Get mine cart total qty.
     *
     * @param int $customerId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMineCartTotalQty($customerId);

    /**
     * Get guest cart total qty.
     *
     * @param string $guestToken
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGuestCartTotalQty($guestToken);

    /**
     * Get mine cart items.
     *
     * @param int $customerId
     * @return \AlbertMage\Quote\Api\CartInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMineCartInfo($customerId);

    /**
     * Get guest cart items.
     *
     * @param string $guestToken
     * @return \AlbertMage\Quote\Api\CartInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGuestCartInfo($guestToken);

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

    /**
     * Update mine cart item.
     *
     * @param int $customerId
     * @param int $itemId
     * @param float $qty
     * @param int $isActive
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateMineItem($customerId, $itemId, $qty, $isActive);

    /**
     * Update guest cart item.
     *
     * @param string $guestToken
     * @param int $itemId
     * @param float $qty
     * @param int $isActive
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateGuestItem($guestToken, $itemId, $qty, $isActive);

    /**
     * Select all mine cart item.
     *
     * @param int $customerId
     * @param int $selected
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function selectAllMineItems($customerId, $selected);

    /**
     * Select all guest cart item.
     *
     * @param string $guestToken
     * @param int $selected
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function selectAllGuestItems($guestToken, $selected);

    /**
     * Remove mine cart item.
     *
     * @param int $customerId
     * @param int $itemId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function removeMineItem($customerId, $itemId);

    /**
     * Remove guest cart item.
     *
     * @param string $guestToken
     * @param int $itemId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function removeGuestItem($guestToken, $itemId);
}
