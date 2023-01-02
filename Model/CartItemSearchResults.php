<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Notification\Model;

use AlbertMage\Notification\Api\Data\CartItemSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with cart item search results.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartItemSearchResults extends SearchResults implements CartItemSearchResultsInterface
{
}
