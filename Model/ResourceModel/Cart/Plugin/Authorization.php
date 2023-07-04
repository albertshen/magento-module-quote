<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model\ResourceModel\Cart\Plugin;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use AlbertMage\Quote\Model\Cart;
use AlbertMage\Quote\Model\ResourceModel\Cart as ResourceCart;

class Authorization
{
    /**
     * @var UserContextInterface
     */
    protected $userContext;

    /**
     * @param UserContextInterface $userContext
     */
    public function __construct(
        UserContextInterface $userContext
    ) {
        $this->userContext = $userContext;
    }

    /**
     * @param ResourceCart $subject
     * @param ResourceCart $result
     * @param \Magento\Framework\Model\AbstractModel $cart
     * @return ResourceCart
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterLoad(
        ResourceCart $subject,
        ResourceCart $result,
        \Magento\Framework\Model\AbstractModel $cart
    ) {
        if ($cart instanceof Cart) {
            if (!$this->isAllowed($cart)) {
                throw NoSuchEntityException::singleField('cartId', $cart->getId());
            }
        }
        return $result;
    }

    /**
     * Checks if cart is allowed for current customer
     *
     * @param \AlbertMage\Quote\Model\Cart $cart
     * @return bool
     */
    protected function isAllowed(Cart $cart)
    {
        return $this->userContext->getUserType() == UserContextInterface::USER_TYPE_CUSTOMER
            ? $cart->getCustomerId() == $this->userContext->getUserId()
            : true;
    }
}
