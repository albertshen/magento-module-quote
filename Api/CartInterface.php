<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api;

/**
 * Cart Interface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartInterface
{

    const ID = 'entity_id';

    const CART_ITEMS = 'cart_items';

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
     * Get cartItems
     *
     * @return \AlbertMage\Quote\Api\Data\CartItemInterface[]
     */
    public function getCartItems();

    /**
     * Set cartItems
     *
     * @param \AlbertMage\Quote\Api\Data\CartItemInterface[] $cartItems
     * @return $this
     */
    public function setCartItems($cartItems);

}
