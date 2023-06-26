<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Quote\Model\Webapi;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Webapi\Rest\Request\ParamOverriderInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Rest\Request;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;
use AlbertMage\Quote\Api\Data\CartInterfaceFactory;


/**
 * Replaces a "%cart_id%" value with the current authenticated customer's cart
 */
class ParamOverriderCartId implements ParamOverriderInterface
{
    /**
     * @var UserContextInterface
     */
    private $userContext;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var CartInterfaceFactory
     */
    private $cartFactory;

    /**
     * @var SocialAccountInterfaceFactory
     */
    protected $socialAccountInterfaceFactory;

    /**
     * Constructs an object to override the cart ID parameter on a request.
     *
     * @param UserContextInterface $userContext
     * @param Request $request
     * @param CartInterfaceFactory $cartFactory
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     */
    public function __construct(
        UserContextInterface $userContext,
        Request $request,
        CartInterfaceFactory $cartFactory,
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory
    ) {
        $this->userContext = $userContext;
        $this->request = $request;
        $this->cartFactory = $cartFactory;
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getOverriddenValue()
    {
        try {
            if ($this->userContext->getUserType() === UserContextInterface::USER_TYPE_CUSTOMER) {

                $customerId = $this->userContext->getUserId();

                $cart = $this->cartFactory->create()->load($customerId, 'customer_id');
                if ($cart) {
                    return $cart->getId();
                }
            }
            if ($guestToken = $this->request->getParam('guest_token')) {

                $guest = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');
                
                $cart = $this->cartFactory->create()->load($guest->getId(), 'guest_id');

                if ($cart) {
                    return $cart->getId();
                }
            }
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Current customer does not have an cart.'));
        }
        return null;
    }
}
