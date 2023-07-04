<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

/**
 * Set city and district before quote submit
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

        //if ('wechatpay' == $order->getPayment()->getMethod()) {
        $order->setState(Order::STATE_PENDING_PAYMENT)->setStatus(Order::STATE_PENDING_PAYMENT);
        //}
        
    }
}
