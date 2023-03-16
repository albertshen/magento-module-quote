<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model\Cart;

use AlbertMage\Quote\Api\Data\TotalsItemInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

/**
 * Cart item totals.
 *
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class TotalsItem extends AbstractExtensibleObject implements TotalsItemInterface
{
    /**
     * Set totals item id
     *
     * @param int $id
     * @return $this
     */
    public function setItemId($id)
    {
        return $this->setData(self::KEY_ITEM_ID, $id);
    }

    /**
     * Get totals item id
     *
     * @return int|null Item id
     */
    public function getItemId()
    {
        return $this->_get(self::KEY_ITEM_ID);
    }

    /**
     * Returns the item price in quote currency.
     *
     * @return float Item price in quote currency.
     */
    public function getPrice()
    {
        return $this->_get(self::KEY_PRICE);
    }

    /**
     * Sets the item price in quote currency.
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        return $this->setData(self::KEY_PRICE, $price);
    }

    /**
     * Returns the item quantity.
     *
     * @return int Item quantity.
     */
    public function getQty()
    {
        return $this->_get(self::KEY_QTY);
    }

    /**
     * Sets the item quantity.
     *
     * @param int $qty
     * @return $this
     */
    public function setQty($qty)
    {
        return $this->setData(self::KEY_QTY, $qty);
    }

    /**
     * Returns the row total in quote currency.
     *
     * @return float Row total in quote currency.
     */
    public function getRowTotal()
    {
        return $this->_get(self::KEY_ROW_TOTAL);
    }

    /**
     * Sets the row total in quote currency.
     *
     * @param float $rowTotal
     * @return $this
     */
    public function setRowTotal($rowTotal)
    {
        return $this->setData(self::KEY_ROW_TOTAL, $rowTotal);
    }

    /**
     * Returns the discount amount in quote currency.
     *
     * @return float|null Discount amount in quote currency. Otherwise, null.
     */
    public function getDiscountAmount()
    {
        return $this->_get(self::KEY_DISCOUNT_AMOUNT);
    }

    /**
     * Sets the discount amount in quote currency.
     *
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount)
    {
        return $this->setData(self::KEY_DISCOUNT_AMOUNT, $discountAmount);
    }

    /**
     * Returns the discount percent.
     *
     * @return float|null Discount percent. Otherwise, null.
     */
    public function getDiscountPercent()
    {
        return $this->_get(self::KEY_DISCOUNT_PERCENT);
    }

    /**
     * Sets the discount percent.
     *
     * @param float $discountPercent
     * @return $this
     */
    public function setDiscountPercent($discountPercent)
    {
        return $this->setData(self::KEY_DISCOUNT_PERCENT, $discountPercent);
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->_get(self::KEY_PRODUCT);
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(\AlbertMage\Catalog\Api\Data\ProductInterface $product)
    {
        return $this->setData(self::KEY_PRODUCT, $product);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsActive()
    {
        return $this->_get(self::KEY_IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::KEY_IS_ACTIVE, $isActive);
    }

    /**
     * {@inheritdoc}
     *
     * @return \AlbertMage\Quote\Api\Data\TotalsItemExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \AlbertMage\Quote\Api\Data\TotalsItemExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\AlbertMage\Quote\Api\Data\TotalsItemExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

}
