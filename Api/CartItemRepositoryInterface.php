<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api;

/**
 * Cart item CRUD interface.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartItemRepositoryInterface
{
    /**
     * Save cart item.
     *
     * @param \AlbertMage\Quote\Api\Data\CartItemInterface $cartItem
     * @return \AlbertMage\Quote\Api\Data\CartItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\AlbertMage\Quote\Api\Data\CartItemInterface $cartItem);

    /**
     * Delete cart item.
     *
     * @param \AlbertMage\Quote\Api\Data\CartItemInterface $cartItem
     * @return \AlbertMage\Quote\Api\Data\CartItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\AlbertMage\Quote\Api\Data\CartItemInterface $cartItem);

    /**
     * Retrieve cart item.
     *
     * @param int $cartItemId
     * @return \AlbertMage\Quote\Api\Data\CartItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($cartItemId);

    /**
     * Retrieve cart item matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\Quote\Api\Data\CartSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
