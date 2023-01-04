<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Model;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use AlbertMage\Quote\Api\CartManagementInterface;
use AlbertMage\Quote\Api\Data\CartInterfaceFactory;
use AlbertMage\Quote\Model\ResourceModel\CartRepositoryFactory;
use AlbertMage\Quote\Model\ResourceModel\CartItemRepositoryFactory;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartManagement implements CartManagementInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CartInterfaceFactory
     */
    protected $cartInterfaceFactory;

    /**
     * @var CartItemRepositoryFactory
     */
    protected $cartItemRepositoryFactory;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param ProductFactory $productFactory;
     * @param CartInterfaceFactory $cartInterfaceFactory
     * @param CartRepositoryFactory $cartRepositoryFactory
     * @param CartItemRepositoryFactory $cartItemRepositoryFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ProductFactory $productFactory,
        CartInterfaceFactory $cartInterfaceFactory,
        CartRepositoryFactory $cartRepositoryFactory,
        CartItemRepositoryFactory $cartItemRepositoryFactory
    ) {
        $this->storeManager = $storeManager;
        $this->productFactory = $productFactory;
        $this->cartInterfaceFactory = $cartInterfaceFactory;
        $this->cartRepositoryFactory = $cartRepositoryFactory;
        $this->cartItemRepositoryFactory = $cartItemRepositoryFactory;
    }

    /**
     * @inheritDoc
     */
    public function addItem($customerId, $productId)
    {
        $product = $this->productFactory->create()->load($productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('The product doesn\'t exit.'),

            );
        }

        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('The product doesn\'t exit.'),

            );
        }
        
        $cartId = $this->getCartId($customerId);
        $cartItemRepository = $this->cartItemRepositoryFactory->create();
        $cartItem = $cartItemRepository->getOneByProductId($cartId, $productId);
        if($cartItem->getId()) {
            $cartItem->setQty($cartItem->getQty() + 1);
        } else {
            $cartItem->setCartId($cartId);
            $cartItem->setProductId($productId);
            $cartItem->setQty(1);
            $cartItem->setIsActive(1);
        }
        $cartItemRepository->save($cartItem);

        return '';
    }

    /**
     * @param int $customerId
     * @return int
     */
    private function getCartId($customerId)
    {
        $cart = $this->cartInterfaceFactory->create()->load($customerId, 'customer_id');
        if (!$cart->getId()) {
            $cart = $this->cartInterfaceFactory->create();
            $cart->setCustomerId($customerId);
            $cart->setStoreId($this->storeManager->getStore()->getId());
            $this->cartRepositoryFactory->create()->save($cart);
        }
        return $cart->getId();
    }

}
