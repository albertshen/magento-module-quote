<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api\Data;

/**
 * Cart Interface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const STORE_ID = 'store_id';
    const CUSTOMER_ID = 'customer_id';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get storeId
     *
     * @return int
     */
    public function getStoreId();

    /**
     * Set storeId
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * Get customerId
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set customerId
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

}
