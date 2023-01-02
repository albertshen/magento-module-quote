<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model\ResourceModel\CartItem;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Quote\Model\CartItem::class,
            \AlbertMage\Quote\Model\ResourceModel\CartItem::class);
    }
}