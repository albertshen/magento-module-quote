<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Reset applied rules to quote before collecting totals
 */
class ServiceQuoteSubmitObserver implements ObserverInterface
{

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $quote = $observer->getQuote();

        $order->getBillingAddress()->setDistrict($quote->getBillingAddress()->getDistrict());
        $order->getShippingAddress()->setDistrict($quote->getShippingAddress()->getDistrict());
        $order->getBillingAddress()->setDistrictId($quote->getBillingAddress()->getDistrictId());
        $order->getShippingAddress()->setDistrictId($quote->getShippingAddress()->getDistrictId());
        $order->getBillingAddress()->setCityId($quote->getBillingAddress()->getCityId());
        $order->getShippingAddress()->setCityId($quote->getShippingAddress()->getCityId());
        
    }
}
