<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Quote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use AlbertMage\Quote\Model\CartManagement;

/**
 * Class responsive for sending order emails when it's created through storefront.
 */
class SubmitObserver implements ObserverInterface
{
    /**
     * @var CartManagement
     */
    private $cartManagement;

    /**
     * @param CartManagement $cartManagement
     */
    public function __construct(
        CartManagement $cartManagement
    ) {
        $this->cartManagement = $cartManagement;
    }

    /**
     * Send order email.
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var  Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->create(\AlbertMage\Quote\Api\Data\CartInterface::class)->load($quote->getId(), 'quote_id');
        if ($cart->getId()) {
        	$this->cartManagement->emptyCart($cart);
        }
    }
}
