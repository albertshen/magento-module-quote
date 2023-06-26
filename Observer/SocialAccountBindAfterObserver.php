<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use AlbertMage\Quote\Api\Data\CartInterfaceFactory;
use AlbertMage\Quote\Api\CartRepositoryInterface;

/**
 * 
 */
class SocialAccountBindAfterObserver implements ObserverInterface
{

    /**
     * @var CartInterfaceFactory
     */
    protected $cartInterfaceFactory;

    /**
     * Cart repository.
     *
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @param CartInterfaceFactory $cartInterfaceFactory
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        CartInterfaceFactory $cartInterfaceFactory,
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartInterfaceFactory = $cartInterfaceFactory;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $socialAccount = $observer->getSocialAccount();

        $cart = $this->cartInterfaceFactory->create()->load($socialAccount->getId(), 'guest_id');

        $cart->setCustomerId($socialAccount->getCustomer()->getId());
        
        $this->cartRepository->save($cart);
        
    }
}
