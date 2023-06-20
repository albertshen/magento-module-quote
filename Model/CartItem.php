<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use AlbertMage\Quote\Api\Data\CartItemInterface;

/**
 * Class CartItem
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartItem extends AbstractModel implements CartItemInterface
{
    
    /**
     * Initialize cart item model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Quote\Model\ResourceModel\CartItem::class);
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
    public function getCartId()
    {
        return $this->getData(self::CART_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCartId($cartId)
    {
        $this->setData(self::CART_ID, $cartId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId)
    {
        $this->setData(self::PRODUCT_ID, $productId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku($sku)
    {
        $this->setData(self::SKU, $sku);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProduct()
    {
        $productListItem = $this->getData('product');
        if (null === $productListItem) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $product = $objectManager->get(\Magento\Catalog\Model\Product::class)->load($this->getProductId());
            $productListItem = $objectManager->get(\AlbertMage\Catalog\Model\ProductManagement::class)->getListItem($product);
            $this->setData('product', $productListItem);
        }
        return $productListItem;
    }

    public function setProduct(\AlbertMage\Catalog\Api\Data\ProductInterface $product)
    {

    }

    /**
     * @inheritDoc
     */
    public function getQty()
    {
        return $this->getData(self::QTY);
    }

    /**
     * @inheritDoc
     */
    public function setQty($qty)
    {
        $this->setData(self::QTY, $qty);
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * @inheritDoc
     */
    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getQuoteItem()
    {
        return $this->getData(self::QUOTE_ITEM);
    }

    /**
     * @inheritDoc
     */
    public function setQuoteItem(\Magento\Quote\Api\Data\CartItemInterface $quoteItem)
    {
        $this->setData(self::QUOTE_ITEM, $quoteItem);
        return $this;
    }

}
