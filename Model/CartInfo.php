<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model;

use Magento\Framework\Model\AbstractModel;
use AlbertMage\Quote\Api\CartInterface;

/**
 * Class Cart Info
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartInfo extends AbstractModel implements CartInterface
{
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
       return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getCartItems()
    {
        return $this->getData(self::CART_ITEMS);
    }

    /**
     * @inheritDoc
     */
    public function setCartItems($cartItems)
    {
       return $this->setData(self::CART_ITEMS, $cartItems);
    }
}