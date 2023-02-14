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
use AlbertMage\Quote\Model\ResourceModel\CartRepository;
use AlbertMage\Quote\Model\ResourceModel\CartItemRepository;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;

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
     * @var CartRepository
     */
    protected $cartRepository;

    /**
     * @var CartItemRepository
     */
    protected $cartItemRepository;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var SocialAccountInterfaceFactory
     */
    protected $socialAccountFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param ProductFactory $productFactory;
     * @param CartInterfaceFactory $cartInterfaceFactory
     * @param CartRepository $cartRepository
     * @param CartItemRepository $cartItemRepository
     * @param SocialAccountInterfaceFactory $socialAccountFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ProductFactory $productFactory,
        CartInterfaceFactory $cartInterfaceFactory,
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        SocialAccountInterfaceFactory $socialAccountFactory
    ) {
        $this->storeManager = $storeManager;
        $this->productFactory = $productFactory;
        $this->cartInterfaceFactory = $cartInterfaceFactory;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->socialAccountFactory = $socialAccountFactory;
    }

    /**
     * @inheritDoc
     */
    public function addMineItem($customerId, $productId)
    {
        $product = $this->productFactory->create()->load($productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('The product doesn\'t exit.'),

            );
        }
        
        $cart = $this->cartInterfaceFactory->create()->load($customerId, 'customer_id');

        if (!$cart->getId()) {
            $cart = $this->cartInterfaceFactory->create();
            $cart->setCustomerId($customerId);
            $cart->setStoreId($this->storeManager->getStore()->getId());
            $this->cartRepository->save($cart);
        }

        return $this->addItem($cart->getId(), $product);

    }

    /**
     * @inheritDoc
     */
    public function addGuestItem($guestToken, $productId)
    {
        $product = $this->productFactory->create()->load($productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('The product doesn\'t exit.'),

            );
        }

        $guest = $this->socialAccountFactory->create()->load($guestToken, 'unique_hash');

        $guestId = $guest->getOpenId();

        $cart = $this->cartInterfaceFactory->create()->load($guestId, 'guest_id');

        if (!$cart->getId()) {
            $cart = $this->cartInterfaceFactory->create();
            $cart->setGuestId($guestId);
            $cart->setStoreId($this->storeManager->getStore()->getId());
            $this->cartRepository->save($cart);
        }

        return $this->addItem($cart->getId(), $product);

    }

    /**
     * @param int $cartId
     * @param \Magento\Catalog\Model\Product $product
     * @return int
     */
    private function addItem($cartId, \Magento\Catalog\Model\Product $product)
    {

        $productId = $product->getId();
        $cartItem = $this->cartItemRepository->getOneByProductId($cartId, $productId);
        if($cartItem->getId()) {
            $cartItem->setQty($cartItem->getQty() + 1);
        } else {
            $cartItem->setCartId($cartId);
            $cartItem->setProductId($productId);
            $cartItem->setSku($product->getSku());
            $cartItem->setQty(1);
            $cartItem->setIsActive(1);
        }
        $this->cartItemRepository->save($cartItem);

        return $this->getCartTotalQty($cartId);

    }

    /**
     * @param int $cartId
     * @return int
     */
    private function getCartTotalQty($cartId)
    {
        $cartItemCollection = $this->cartItemRepository->getByCartId($cartId);

        $count = 0;
        foreach($cartItemCollection as $cartItem) {
            $count += (int) $cartItem->getQty();
        }
        return $count;
    }

}
