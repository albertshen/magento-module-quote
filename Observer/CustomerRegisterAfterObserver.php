<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use AlbertMage\Quote\Api\Data\CartInterface;
use AlbertMage\Quote\Api\CartItemRepositoryInterface;

/**
 * Remove items in cart after order placed
 */
class CustomerRegisterAfterObserver implements ObserverInterface
{

    /**
     * @var CartInterface
     */
    protected $cart;

    /**
     * Cart item repository.
     *
     * @var CartItemRepositoryInterface
     */
    protected $cartItemRepository;

    /**
     * @param CartInterface $cart
     * @param CartItemRepositoryInterface $cartItemRepository
     */
    public function __construct(
        CartInterface $cart,
        CartItemRepositoryInterface $cartItemRepository
    ) {
        $this->cart = $cart;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getCustomer();

        $productIds = [];
        foreach ($order->getAllItems() as $orderItem) {
            $productIds[] = $orderItem->getProductId();
        }

        $cart = $this->cart->load($quote->getCustomerId(), 'customer_id');

        foreach($cart->getAllItems() as $cartItem) {
            if (in_array($cartItem->getProductId(), $productIds)) {
                $this->cartItemRepository->delete($cartItem);
            }
        }
        
    }
}
