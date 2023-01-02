<?php
/**
 * Cart resource model
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Cart extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('cart', 'entity_id');
    }
}
