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
use AlbertMage\Quote\Api\Data\CartInterface;
use AlbertMage\Quote\Model\ResourceModel\CartRepository;
use AlbertMage\Quote\Model\ResourceModel\CartItemRepository;

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
     * @var CartInterface
     */
    protected $cart;

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
     * @param StoreManagerInterface $storeManager
     * @param CartInterface $cart
     * @param ProductFactory $productFactory
     * @param CartInterfaceFactory $cartInterfaceFactory
     * @param CartRepository $cartRepository
     * @param CartItemRepository $cartItemRepository
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CartInterface $cart,
        ProductFactory $productFactory,
        CartInterfaceFactory $cartInterfaceFactory,
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository
    ) {
        $this->storeManager = $storeManager;
        $this->cart = $cart;
        $this->productFactory = $productFactory;
        $this->cartInterfaceFactory = $cartInterfaceFactory;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
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

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $guest = $objectManager->create(\AlbertMage\Customer\Api\Data\SocialAccountInterface::class)->load($guestToken, 'unique_hash');

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
     * Merge the guest cart with customer cart
     * 
     * @param string $guestId
     * @param string $customerId
     * @return void
     */
    public function mergeGuestCart($guestId, $customerId)
    {
        $guestCart = $this->cart->load($guestId, 'guest_id');

        if ($guestCart->getId()) {

            //Create customer cart if not exist
            $customerCart = $this->cart->load($customerId, 'customer_id');
            if (!$customerCart->getId()) {
                $customerCart->setCustomerId($customerId);
                $customerCart->setStoreId($this->storeManager->getStore()->getId());
                $this->cartRepository->save($customerCart);
            }

            //Move guest cart items into customer cart
            foreach ($guestCart->getAllItems() as $cartItem) {
                $product = $this->productFactory->create()->load($cartItem->getProductId());
                $this->addItem($customerCart->getId(), $product);
            }

            //Empty and delete guest cart
            foreach ($guestCart->getAllItems() as $cartItem) {
                $this->cartItemRepository->delete($cartItem);
            }
            $this->cartRepository->delete($guestCart);

            //Delete guest quote
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $quoteRepository = $objectManager->create(\Magento\Quote\Api\CartRepositoryInterface::class);
            try {
                $quote = $quoteRepository->getActiveForCustomer($customerId);
                $quoteRepository->delete($quote);
            } catch (NoSuchEntityException $e) {
            }

        }
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

    /**
     * Empty the cart 
     * Just delete the items in cart not set cart quote id to be 0
     * 
     * @param \AlbertMage\Quote\Api\Data\CartInterface $cart
     * @return void
     */
    private function emptyCart(\AlbertMage\Quote\Api\Data\CartInterface $cart)
    {
        foreach ($cart->getAllItems() as $cartItem) {
            $this->cartItemRepository->delete($cartItem);
        }
        $cart->setQuoteId(0);
        $this->cartRepository->save($cart);
    }

}
