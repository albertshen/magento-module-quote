<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model\Cart;

use AlbertMage\Quote\Api\Data\TotalsInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Cart Totals
 *
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Totals extends AbstractModel implements TotalsInterface
{
    /**
     * Get grand total in quote currency
     *
     * @return float|null
     */
    public function getGrandTotal()
    {
        return $this->getData(self::KEY_GRAND_TOTAL);
    }

    /**
     * Set grand total in quote currency
     *
     * @param float $grandTotal
     * @return $this
     */
    public function setGrandTotal($grandTotal)
    {
        return $this->setData(self::KEY_GRAND_TOTAL, $grandTotal);
    }

    /**
     * Get subtotal in quote currency
     *
     * @return float|null
     */
    public function getSubtotal()
    {
        return $this->getData(self::KEY_SUBTOTAL);
    }

    /**
     * Set subtotal in quote currency
     *
     * @param float $subtotal
     * @return $this
     */
    public function setSubtotal($subtotal)
    {
        return $this->setData(self::KEY_SUBTOTAL, $subtotal);
    }

    /**
     * Get discount amount in quote currency
     *
     * @return float|null
     */
    public function getDiscountAmount()
    {
        return $this->getData(self::KEY_DISCOUNT_AMOUNT);
    }

    /**
     * Set discount amount in quote currency
     *
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount)
    {
        return $this->setData(self::KEY_DISCOUNT_AMOUNT, $discountAmount);
    }

    /**
     * Get subtotal in quote currency with applied discount
     *
     * @return float|null
     */
    public function getSubtotalWithDiscount()
    {
        return $this->getData(self::KEY_SUBTOTAL_WITH_DISCOUNT);
    }

    /**
     * Set subtotal in quote currency with applied discount
     *
     * @param float $subtotalWithDiscount
     * @return $this
     */
    public function setSubtotalWithDiscount($subtotalWithDiscount)
    {
        return $this->setData(self::KEY_SUBTOTAL_WITH_DISCOUNT, $subtotalWithDiscount);
    }

    /**
     * Get shipping amount in quote currency
     *
     * @return float|null
     */
    public function getShippingAmount()
    {
        return $this->getData(self::KEY_SHIPPING_AMOUNT);
    }

    /**
     * Set shipping amount in quote currency
     *
     * @param float $shippingAmount
     * @return $this
     */
    public function setShippingAmount($shippingAmount)
    {
        return $this->setData(self::KEY_SHIPPING_AMOUNT, $shippingAmount);
    }

    /**
     * Get items qty
     *
     * @return int||null
     */
    public function getItemsQty()
    {
        return $this->getData(self::KEY_ITEMS_QTY);
    }

    /**
     * Set items qty
     *
     * @param int $itemsQty
     * @return $this
     */
    public function setItemsQty($itemsQty = null)
    {
        return $this->setData(self::KEY_ITEMS_QTY, $itemsQty);
    }

    /**
     * Get totals by items
     *
     * @return \AlbertMage\Quote\Api\Data\TotalsItemInterface[]|null
     */
    public function getItems()
    {
        return $this->getData(self::KEY_ITEMS);
    }

    /**
     * Get totals by items
     *
     * @param \AlbertMage\Quote\Api\Data\TotalsItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this->setData(self::KEY_ITEMS, $items);
    }

    /**
     * Get coupon code
     *
     * @return string|null
     */
    public function getCouponCode()
    {
        return $this->getData(self::COUPON_CODE);
    }

    /**
     * Set coupon code
     *
     * @param string $couponCode
     * @return $this
     */
    public function setCouponCode($couponCode)
    {
        return $this->setData(self::COUPON_CODE, $couponCode);
    }

    /**
     * Get dynamically calculated totals
     *
     * @return \Magento\Quote\Api\Data\TotalSegmentInterface[]
     */
    public function getTotalSegments()
    {
        return $this->getData(self::KEY_TOTAL_SEGMENTS);
    }

    /**
     * Set dynamically calculated totals
     *
     * @param \Magento\Quote\Api\Data\TotalSegmentInterface[] $totals
     * @return $this
     */
    public function setTotalSegments($totals = [])
    {
        return $this->setData(self::KEY_TOTAL_SEGMENTS, $items);
    }
}
