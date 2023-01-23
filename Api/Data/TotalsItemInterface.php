<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api\Data;

/**
 * Interface TotalsItemInterface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface TotalsItemInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const KEY_ITEM_ID = 'item_id';

    const KEY_PRICE = 'price';

    const KEY_QTY = 'qty';

    const KEY_ROW_TOTAL = 'row_total';

    const KEY_DISCOUNT_AMOUNT = 'discount_amount';

    const KEY_DISCOUNT_PERCENT = 'discount_percent';

    const KEY_PRODUCT = 'product';

    const KEY_IS_ACTIVE = 'is_active';

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
     * @return int|null Item id
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
     * Returns the product.
     *
     * @return \AlbertMage\Catalog\Api\Data\ProductListItemInterface.
     */
    public function getProduct();

    /**
     * Sets the product.
     *
     * @param \AlbertMage\Catalog\Api\Data\ProductListItemInterface $product
     * @return $this
     */
    public function setProduct(\AlbertMage\Catalog\Api\Data\ProductListItemInterface $product);

    /**
     * Returns is active
     *
     * @return int
     */
    public function getIsActive();

    /**
     * Sets is active.
     *
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \AlbertMage\Quote\Api\Data\TotalsItemExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \AlbertMage\Quote\Api\Data\TotalsItemExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\AlbertMage\Quote\Api\Data\TotalsItemExtensionInterface $extensionAttributes);
    
}
