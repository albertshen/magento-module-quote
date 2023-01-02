<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api;

/**
 * Cart CRUD interface.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartRepositoryInterface
{
    /**
     * Save cart.
     *
     * @param \AlbertMage\Quote\Api\Data\CartInterface $cart
     * @return \AlbertMage\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\AlbertMage\Quote\Api\Data\CartInterface $cart);

    /**
     * Delete cart.
     *
     * @param \AlbertMage\Quote\Api\Data\CartInterface $cart
     * @return \AlbertMage\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\AlbertMage\Quote\Api\Data\CartInterface $cart);

    /**
     * Retrieve cart.
     *
     * @param int $cartId
     * @return \AlbertMage\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($cartId);

    /**
     * Retrieve cart matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\Quote\Api\Data\CartSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
