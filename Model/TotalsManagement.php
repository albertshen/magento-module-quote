<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Quote\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Quote\Api\Data\TotalsInterface;
use Magento\Quote\Api\Data\TotalsItemInterface;
use AlbertMage\Quote\Api\Data\TotalsInterfaceFactory;
use AlbertMage\Quote\Api\Data\TotalsItemInterfaceFactory;
use AlbertMage\Catalog\Api\ProductManagementInterface;
use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class TotalsManagement
{
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var TotalsInterfaceFactory
     */
    protected $totalsInterfaceFactory;

    /**
     * @var TotalsItemInterfaceFactory
     */
    protected $totalsItemInterfaceFactory;

    /**
     * @var ProductManagementInterface
     */
    protected $productManagement;

    /**
     * @param DataObjectHelper $dataObjectHelper
     * @param TotalsInterfaceFactory $totalsInterfaceFactory
     * @param TotalsItemInterfaceFactory $totalsItemInterfaceFactory
     * @param ProductManagementInterface $productManagement
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        TotalsInterfaceFactory $totalsInterfaceFactory,
        TotalsItemInterfaceFactory $totalsItemInterfaceFactory,
        ProductManagementInterface $productManagement
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->totalsInterfaceFactory = $totalsInterfaceFactory;
        $this->totalsItemInterfaceFactory = $totalsItemInterfaceFactory;
        $this->productManagement = $productManagement;
    }

    /**
     * @param \Magento\Quote\Api\Data\TotalsInterface $totals
     * @return \AlbertMage\Quote\Api\Data\TotalsInterface
     */
    public function getTotals(\Magento\Quote\Api\Data\TotalsInterface $totals)
    {

        $totalsData = $totals->toArray();

        unset($totalsData[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY]);
        unset($totalsData[TotalsInterface::KEY_ITEMS]);
 
        $newTotalsItems = [];
        foreach ($totals->getItems() as $totalsItem) {
            $newTotalsItems[] = $this->getTotalsItem($totalsItem);
        }
        $totalsData['items'] = $newTotalsItems;

        $newTotals = $this->totalsInterfaceFactory->create(['data' => $totalsData]);

        // $newTotals = $this->totalsInterfaceFactory->create();
        // $this->dataObjectHelper->populateWithArray(
        //     $newTotals,
        //     $totalsData,
        //     \AlbertMage\Quote\Api\Data\TotalsInterface::class
        // );

        // $newTotalsItems = [];
        // foreach ($totals->getItems() as $totalItem) {
        //     $newTotalsItems[] = $this->getTotalsItem($totalItem);
        // }
        // $newTotals->setItems($newTotalsItems);

        return $newTotals;
    }

    /**
     * @param \Magento\Quote\Api\Data\TotalsItemInterface $totalsItem
     * @return \AlbertMage\Quote\Api\Data\TotalsItemInterface
     */
    public function getTotalsItem(\Magento\Quote\Api\Data\TotalsItemInterface $totalsItem)
    {

        $item = $totalsItem->__toArray();

        $product = $this->getTotalsListItemProduct($totalsItem->getExtensionAttributes()->getProductId());

        unset($item[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY]);

        $newItem = $this->totalsItemInterfaceFactory->create(['data' => $item]);

        $newItem->setProduct($product);

        return $newItem;
    }

    /**
     * @param \Magento\Quote\Api\Data\TotalsInterface $totals
     * @param \AlbertMage\Quote\Api\Data\CartInterface $cart
     * @return \AlbertMage\Quote\Api\Data\TotalsItemInterface
     */
    public function mergeTotalsItemsToCart(
        \Magento\Quote\Api\Data\TotalsInterface $totals,
        \AlbertMage\Quote\Api\Data\CartInterface $cart
    ) {

        $quoteTotals = $this->getTotals($totals);
        
        $quoteTotalsItems = [];
        foreach ($quoteTotals->getItems() as $item) {
            $quoteTotalsItems[$item->getProduct()->getId()] = $item;
        }

        $totalsItems = [];
        foreach($cart->getAllItems() as $cartItem) {
            $productId = $cartItem->getProductId();
            $totalsItem = $this->createTotalsItemFromCart($productId, $cartItem->getQty());
            if (isset($quoteTotalsItems[$productId])) {
                $totalsItem = $quoteTotalsItems[$productId];
                $totalsItem->setIsActive(1);
            } else {
                $totalsItem->setIsActive(0);
            }
            $totalsItem->setItemId($cartItem->getId());
            $totalsItems[] = $totalsItem;
        }

        $quoteTotals->setItems($totalsItems);

        return $quoteTotals;
    }

    /**
     * Create TotalsItem from cart
     *
     * @param int $productId
     * @param int $qty
     * @return \AlbertMage\Quote\Api\Data\TotalsItemInterface
     */
    private function createTotalsItemFromCart($productId, $qty = 1)
    {
        $totalsItem = $this->totalsItemInterfaceFactory->create();
        $product = $this->getTotalsListItemProduct($productId);
        $totalsItem->setProduct($product);
        $totalsItem->setPrice($product->getPrice());
        $totalsItem->setQty($qty);
        $totalsItem->setRowTotal($product->getPrice() * $qty);
        return $totalsItem;
    }

    /**
     * Get product in total list item
     *
     * @param int $productId
     * @return \AlbertMage\Catalog\Api\Data\ProductInterface
     */
    private function getTotalsListItemProduct($productId)
    {
        return $this->productManagement->getListItemById($productId);
    }

}
