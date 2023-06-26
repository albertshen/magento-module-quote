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
use AlbertMage\Quote\Api\CartInterfaceFactory as CartInfoInterfaceFactory;
use AlbertMage\Quote\Api\Data\CartInterfaceFactory;
use AlbertMage\Quote\Api\Data\CartInterface;
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
     * @var CartInterface
     */
    protected $cart;

    /**
     * @var CartInfoInterfaceFactory
     */
    protected $cartInfoInterfaceFactory;

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
    protected $socialAccountInterfaceFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param CartInterface $cart
     * @param CartInfoInterfaceFactory $cartInfoInterfaceFactory
     * @param ProductFactory $productFactory
     * @param CartInterfaceFactory $cartInterfaceFactory
     * @param CartRepository $cartRepository
     * @param CartItemRepository $cartItemRepository
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CartInterface $cart,
        CartInfoInterfaceFactory $cartInfoInterfaceFactory,
        ProductFactory $productFactory,
        CartInterfaceFactory $cartInterfaceFactory,
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory
    ) {
        $this->storeManager = $storeManager;
        $this->cart = $cart;
        $this->cartInfoInterfaceFactory = $cartInfoInterfaceFactory;
        $this->productFactory = $productFactory;
        $this->cartInterfaceFactory = $cartInterfaceFactory;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
    }

    /**
     * @inheritDoc
     */
    public function getMineCartTotalQty($customerId)
    {
        $cart = $this->cartInterfaceFactory->create()->load($customerId, 'customer_id');

        $cartTotalQty = 0;
        foreach ($this->getCartItems($cart) as $cartItem) {
            if ($cartItem->getIsActive()) {
                $cartTotalQty += $cartItem->getQty();
            }
        }
        return $cartTotalQty;

    }

    /**
     * @inheritDoc
     */
    public function getGuestCartTotalQty($guestToken)
    {
        $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
        if (!$guest->getId()) {
            throw new NoSuchEntityException(
                __('Token doesn\'t exit.'),

            );
        }

        $cart = $this->cartInterfaceFactory->create()->load($guest->getId(), 'guest_id');

        $cartTotalQty = 0;
        foreach ($this->getCartItems($cart) as $cartItem) {
            if ($cartItem->getIsActive()) {
                $cartTotalQty += $cartItem->getQty();
            }
        }
        return $cartTotalQty;

    }

    /**
     * @inheritDoc
     */
    public function getMineCartInfo($customerId)
    {
        $cart = $this->cartInterfaceFactory->create()->load($customerId, 'customer_id');

        $cartInfo = $this->cartInfoInterfaceFactory->create();
        $cartInfo->setId($cart->getId());
        $cartInfo->setCartItems($this->getCartItems($cart));

        return $cartInfo;
    }

    /**
     * @inheritDoc
     */
    public function getGuestCartInfo($guestToken)
    {
        $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
        if (!$guest->getId()) {
            throw new NoSuchEntityException(
                __('Token doesn\'t exit.'),

            );
        }

        $cart = $this->cartInterfaceFactory->create()->load($guest->getId(), 'guest_id');

        $cartInfo = $this->cartInfoInterfaceFactory->create();
        $cartInfo->setId($cart->getId());
        $cartInfo->setCartItems($this->getCartItems($cart));

        return $cartInfo;
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
        $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
        if (!$guest->getId()) {
            throw new NoSuchEntityException(
                __('Token doesn\'t exit.'),

            );
        }

        $product = $this->productFactory->create()->load($productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('The product doesn\'t exit.'),

            );
        }

        $cart = $this->cartInterfaceFactory->create()->load($guest->getId(), 'guest_id');

        if (!$cart->getId()) {
            $cart = $this->cartInterfaceFactory->create();
            $cart->setGuestId($guest->getId());
            $cart->setStoreId($this->storeManager->getStore()->getId());
            $this->cartRepository->save($cart);
        }

        return $this->addItem($cart->getId(), $product);

    }

    /**
     * @inheritDoc
     */
    public function updateMineItem($customerId, $itemId, $qty, $isActive)
    {

        $cartItem = $this->cartItemRepository->getById($itemId);

        $cart = $this->cartInterfaceFactory->create()->load($cartItem->getCartId());
        if ($cart->getCustomerId() != $customerId) {
            throw new NoSuchEntityException(
                __('The cart item doesn\'t exit.'),

            );
        }

        $cartItem->setQty($qty);

        $cartItem->setIsActive($isActive);

        $this->cartItemRepository->save($cartItem);

        return true;

    }

    /**
     * @inheritDoc
     */
    public function updateGuestItem($guestToken, $itemId, $qty, $isActive)
    {

        $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
        if (!$guest->getId()) {
            throw new NoSuchEntityException(
                __('Token doesn\'t exit.'),

            );
        }

        $cartItem = $this->cartItemRepository->getById($itemId);

        $cart = $this->cartInterfaceFactory->create()->load($cartItem->getCartId());

        if ($cart->getGuestId() != $guest->getId()) {
            throw new NoSuchEntityException(
                __('The cart item doesn\'t exit.'),

            );
        }

        $cartItem->setQty($qty);

        $cartItem->setIsActive($isActive);

        $cartItem->save();

        return true;

    }

    /**
     * @inheritDoc
     */
    public function selectAllMineItems($customerId, $selected)
    {
        $cart = $this->cartInterfaceFactory->create()->load($customerId, 'customer_id');

        foreach($cart->getAllItems() as $cartItem) {
            if ($cartItem->getProduct()->getAvailable()) {
                $cartItem->setIsActive($selected);
                $cartItem->save();
            }
        }

    }

    /**
     * @inheritDoc
     */
    public function selectAllGuestItems($guestToken, $selected)
    {
        $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
        if (!$guest->getId()) {
            throw new NoSuchEntityException(
                __('Token doesn\'t exit.'),

            );
        }

        $cart = $this->cartInterfaceFactory->create()->load($guest->getId(), 'guest_id');

        foreach($cart->getAllItems() as $cartItem) {
            if ($cartItem->getProduct()->getAvailable()) {
                $cartItem->setIsActive($selected);
                $cartItem->save();
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function removeMineItem($customerId, $itemId)
    {
        $cartItem = $this->cartItemRepository->getById($itemId);

        $cart = $this->cartInterfaceFactory->create()->load($cartItem->getCartId());
        if ($cart->customerId() != $customerId) {
            throw new NoSuchEntityException(
                __('The cart item doesn\'t exit.'),

            );
        }

        $this->cartItemRepository->delete($cartItem);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function removeGuestItem($guestToken, $itemId)
    {
        $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
        if (!$guest->getId()) {
            throw new NoSuchEntityException(
                __('Token doesn\'t exit.'),

            );
        }
        
        $cartItem = $this->cartItemRepository->getById($itemId);

        $cart = $this->cartInterfaceFactory->create()->load($cartItem->getCartId());

        if ($cart->getGuestId() != $guest->getId()) {
            throw new NoSuchEntityException(
                __('The cart item doesn\'t exit.'),

            );
        }

        $this->cartItemRepository->delete($cartItem);
        
        return true;
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
                $customerCart->save();
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
     * Get mine cart items.
     *
     * @param \AlbertMage\Quote\Api\Data\CartInterface $cart
     * @return \AlbertMage\Quote\Api\Data\CartItemInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getCartItems(\AlbertMage\Quote\Api\Data\CartInterface $cart)
    {
        $cartItems = [];
        foreach($cart->getAllItems() as $cartItem) {
            if ($cartItem->getProduct()->getStock() && $cartItem->getProduct()->getStock() <= $cartItem->getQty()) {
                $cartItem->setQty($cartItem->getProduct()->getStock());
                $cartItem->save();
            }
            if (!$cartItem->getProduct()->getAvailable()) {
                $cartItem->setIsActive(0);
                $cartItem->save();
            }
            $cartItems[] = $cartItem;
        }
        return $cartItems;
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
        $cartItem->save();

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
        $cart->save();
    }

}
