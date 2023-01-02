<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api\Data;

/**
 * Interface for node search results.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartItemSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get node list.
     *
     * @return \AlbertMage\Quote\Api\Data\CartItemInterface[]
     */
    public function getItems();

    /**
     * Set node list.
     *
     * @param \AlbertMage\Quote\Api\Data\CartItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
