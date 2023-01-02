<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Model;

use AlbertMage\Quote\Api\Data\CartSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with cart search results.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartSearchResults extends SearchResults implements CartSearchResultsInterface
{
}
