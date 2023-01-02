<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model;

use Magento\Framework\Model\AbstractModel;
use AlbertMage\Quote\Api\Data\CartInterface;

/**
 * Class Cart
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Cart extends AbstractModel implements CartInterface
{
    
    /**
     * Initialize cart model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Quote\Model\ResourceModel\Cart::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId($storeId)
    {
        $this->setData(self::STORE_ID, $storeId);
        return $this;
    }

    /**
     * Retrieve cart items array
     *
     * @return array
     */
    public function getAllItems()
    {
        $items = [];
        /** @var \Magento\Quote\Model\Quote\Item $item */
        foreach ($this->getItemsCollection() as $item) {
            $product = $item->getProduct();
            if (!$item->isDeleted() && ($product && (int)$product->getStatus() !== ProductStatus::STATUS_DISABLED)) {
                $items[] = $item;
            }
        }

        return $items;
    }


}
