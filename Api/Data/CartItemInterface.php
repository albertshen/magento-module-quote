<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api\Data;

/**
 * Cart item Interface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartItemInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'item_id';
    const CART_ID = 'cart_id';
    const PRODUCT_ID = 'product_id';
    const SKU = 'sku';
    const QTY = 'qty';
    const IS_ACTIVE = 'is_active';
    const QUOTE_ITEM = 'quote_item';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get cartId
     *
     * @return int
     */
    public function getCartId();

    /**
     * Set cart id
     *
     * @param int $cartId
     * @return $this
     */
    public function setCartId($cartId);

    /**
     * Get product id
     *
     * @return int
     */
    public function getProductId();

    /**
     * Set product id
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId);

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku();

    /**
     * Set sku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku($sku);

    /**
     * Get qty
     *
     * @return float
     */
    public function getQty();

    /**
     * Set qty
     *
     * @param float $qty
     * @return $this
     */
    public function setQty($qty);

    /**
     * Get is active
     *
     * @return int
     */
    public function getIsActive();

    /**
     * Set is active
     *
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get quote item
     *
     * @return \Magento\Quote\Api\Data\CartItemInterface
     */
    public function getQuoteItem();

    /**
     * Set quote item Id
     *
     * @param \Magento\Quote\Api\Data\CartItemInterface $quoteItem
     * @return $this
     */
    public function setQuoteItem(\Magento\Quote\Api\Data\CartItemInterface $quoteItem);

}
