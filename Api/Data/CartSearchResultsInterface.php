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
interface CartSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get node list.
     *
     * @return \AlbertMage\Quote\Api\Data\CartInterface[]
     */
    public function getItems();

    /**
     * Set node list.
     *
     * @param \AlbertMage\Quote\Api\Data\CartInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
