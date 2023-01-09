<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use AlbertMage\Quote\Api\Data\CartInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status as ProductStatus;

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
        $allItems = $this->getData('all_items');
        if (null === $allItems) {
            $cartItemCollection = ObjectManager::getInstance()->get(\AlbertMage\Quote\Model\ResourceModel\CartItem\Collection::class);
            $cartItemCollection->addFieldToFilter('cart_id', ['eq' => $this->getId()]);
            $allItems = $cartItemCollection->getItems();
            $this->setData('all_items', $allItems);
        }
        return $allItems;
    }

    /**
     * Retrieve available cart items array
     *
     * @return array
     */
    public function getAvailableItems()
    {

        $items = $this->getData('available_items');
        if (null === $items) {
            $items = [];
            $cartItemCollection = ObjectManager::getInstance()->get(\AlbertMage\Quote\Model\ResourceModel\CartItem\Collection::class);
            foreach($cartItemCollection->getItems() as $cartItem) {
                if ($cartItem->getIsActive() && !$cartItem->getProduct()->isDisabled() && $cartItem->getProduct()->isAvailable()) {
                    $items[] = $cartItem;
                }
            }
            $this->setData('available_items', $items);
        }
        return $items;
    }

}
