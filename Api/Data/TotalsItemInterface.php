<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api\Data;

/**
 * Interface TotalsItemInterface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface TotalsItemInterface
{
    /**
     * Item id.
     */
    const KEY_ITEM_ID = 'item_id';

    /**
     * Price.
     */
    const KEY_PRICE = 'price';

    /**
     * Quantity.
     */
    const KEY_QTY = 'qty';

    /**
     * Row total.
     */
    const KEY_ROW_TOTAL = 'row_total';

    /**
     * Discount amount.
     */
    const KEY_DISCOUNT_AMOUNT = 'discount_amount';

    /**
     * Discount percent.
     */
    const KEY_DISCOUNT_PERCENT = 'discount_percent';

    /**
     * Item name.
     */
    const KEY_NAME = 'name';

    /**#@-*/

    /**
     * Set totals item id
     *
     * @param int $id
     * @return $this
     */
    public function setItemId($id);

    /**
     * Get totals item id
     *
     * @return int Item id
     */
    public function getItemId();

    /**
     * Returns the item price in quote currency.
     *
     * @return float Item price in quote currency.
     */
    public function getPrice();

    /**
     * Sets the item price in quote currency.
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * Returns the item quantity.
     *
     * @return float Item quantity.
     */
    public function getQty();

    /**
     * Sets the item quantity.
     *
     * @param float $qty
     * @return $this
     */
    public function setQty($qty);

    /**
     * Returns the row total in quote currency.
     *
     * @return float Row total in quote currency.
     */
    public function getRowTotal();

    /**
     * Sets the row total in quote currency.
     *
     * @param float $rowTotal
     * @return $this
     */
    public function setRowTotal($rowTotal);

    /**
     * Returns the discount amount in quote currency.
     *
     * @return float|null Discount amount in quote currency. Otherwise, null.
     */
    public function getDiscountAmount();

    /**
     * Sets the discount amount in quote currency.
     *
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount);

    /**
     * Returns the discount percent.
     *
     * @return float|null Discount percent. Otherwise, null.
     */
    public function getDiscountPercent();

    /**
     * Sets the discount percent.
     *
     * @param float $discountPercent
     * @return $this
     */
    public function setDiscountPercent($discountPercent);

    /**
     * Returns the product name.
     *
     * @return string|null Product name. Otherwise, null.
     */
    public function getName();

    /**
     * Sets the product name.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);
    
}
