<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api\Data;

/**
 * Interface TotalsInterface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface TotalsInterface
{
    /**#@+
     * Constants defined for keys of array, makes typos less likely
     */
    const KEY_GRAND_TOTAL = 'grand_total';

    const KEY_SUBTOTAL = 'subtotal';

    const KEY_DISCOUNT_AMOUNT = 'discount_amount';

    const KEY_SUBTOTAL_WITH_DISCOUNT = 'subtotal_with_discount';

    const KEY_SHIPPING_AMOUNT = 'shipping_amount';

    const KEY_SHIPPING_DISCOUNT_AMOUNT = 'shipping_discount_amount';

    const KEY_ITEMS = 'items';

    const KEY_ITEMS_QTY = 'items_qty';

    /**#@-*/

    /**
     * Get grand total in quote currency
     *
     * @return float|null
     */
    public function getGrandTotal();

    /**
     * Set grand total in quote currency
     *
     * @param float $grandTotal
     * @return $this
     */
    public function setGrandTotal($grandTotal);

    /**
     * Get subtotal in quote currency
     *
     * @return float|null
     */
    public function getSubtotal();

    /**
     * Set subtotal in quote currency
     *
     * @param float $subtotal
     * @return $this
     */
    public function setSubtotal($subtotal);

    /**
     * Get discount amount in quote currency
     *
     * @return float|null
     */
    public function getDiscountAmount();

    /**
     * Set discount amount in quote currency
     *
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount);

    /**
     * Get subtotal in quote currency with applied discount
     *
     * @return float|null
     */
    public function getSubtotalWithDiscount();

    /**
     * Set subtotal in quote currency with applied discount
     *
     * @param float $subtotalWithDiscount
     * @return $this
     */
    public function setSubtotalWithDiscount($subtotalWithDiscount);

    /**
     * Get shipping amount in quote currency
     *
     * @return float|null
     */
    public function getShippingAmount();

    /**
     * Set shipping amount in quote currency
     *
     * @param float $shippingAmount
     * @return $this
     */
    public function setShippingAmount($shippingAmount);

    /**
     * Get items qty
     *
     * @return int||null
     */
    public function getItemsQty();

    /**
     * Set items qty
     *
     * @param int $itemsQty
     * @return $this
     */
    public function setItemsQty($itemsQty = null);

    /**
     * Get totals by items
     *
     * @return \AlbertMage\Quote\Api\Data\TotalsItemInterface[]|null
     */
    public function getItems();

    /**
     * Set totals by items
     *
     * @param \AlbertMage\Quote\Api\Data\TotalsItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
    
}
