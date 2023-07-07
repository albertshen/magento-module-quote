<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use AlbertMage\Quote\Api\Data\CartInterfaceFactory;

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
     * @param CartInterfaceFactory $cartInterfaceFactory
     */
    public function __construct(
        CartInterfaceFactory $cartInterfaceFactory
    ) {
        $this->cartInterfaceFactory = $cartInterfaceFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $socialAccount = $observer->getSocialAccount();

        $cart = $this->cartInterfaceFactory->create()->load($socialAccount->getId(), 'guest_id');

        if($cart->getId()) {
            $cart->setCustomerId($socialAccount->getCustomer()->getId());
            $cart->save();
        }
        
    }
}
