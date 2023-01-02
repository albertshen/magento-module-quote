<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Api;

/**
 * Interface for managing cart.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CartManagementInterface
{
    /**
     * Create customer account.
     *
     * @return \AlbertMage\Quote\Api\Data\TotalPriceInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function calulate();

}
