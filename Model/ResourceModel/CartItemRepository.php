<?php
/**
 * Cart entity resource model
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Quote\Model\ResourceModel;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use AlbertMage\Quote\Api\Data\CartItemInterface;
use AlbertMage\Quote\Api\Data\CartItemInterfaceFactory;
use AlbertMage\Quote\Api\Data\CartItemSearchResultsInterfaceFactory;
use AlbertMage\Quote\Model\ResourceModel\CartItem;
use AlbertMage\Quote\Model\ResourceModel\CartItem\CollectionFactory;

/**
 * Cart item repository.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartItemRepository implements \AlbertMage\Quote\Api\CartItemRepositoryInterface
{

    /**
     * @var \AlbertMage\Quote\Model\CartItemFactory
     */
    protected $cartItemFactory;

    /**
     * @var \AlbertMage\Quote\Model\ResourceModel\CartItem
     */
    protected $cartItemResourceModel;

    /**
     * @var \AlbertMage\Quote\Api\Data\CartItemSearchResultsInterfaceFactory
     */
    protected $cartItemSearchResultsFactory;

    /**
     * @var \AlbertMage\Quote\Model\ResourceModel\CartItem\CollectionFactory
     */
    protected $cartItemCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param \AlbertMage\Quote\Model\CartItemFactory $cartItemFactory
     * @param \AlbertMage\Quote\Model\ResourceModel\CartItem $cartItemResourceModel
     * @param \AlbertMage\Quote\Api\Data\CartItemSearchResultsInterfaceFactory $cartItemSearchResultsFactory
     * @param \AlbertMage\Quote\Model\ResourceModel\CartItem\CollectionFactory $cartItemCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \AlbertMage\Quote\Model\CartItemFactory $cartItemFactory,
        \AlbertMage\Quote\Model\ResourceModel\CartItem $cartItemResourceModel,
        \AlbertMage\Quote\Api\Data\CartItemSearchResultsInterfaceFactory $cartItemSearchResultsFactory,
        \AlbertMage\Quote\Model\ResourceModel\CartItem\CollectionFactory $cartItemCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->cartItemFactory = $cartItemFactory;
        $this->cartItemResourceModel = $cartItemResourceModel;
        $this->cartItemSearchResultsFactory = $cartItemSearchResultsFactory;
        $this->cartItemCollectionFactory = $cartItemCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(\AlbertMage\Quote\Api\Data\CartItemInterface $cartItem)
    {
        $this->cartItemResourceModel->save($cartItem);
        return $cartItem;
    }

    /**
     * @inheritDoc
     */
    public function delete(\AlbertMage\Quote\Api\Data\CartItemInterface $cartItem)
    {
        $this->cartItemResourceModel->delete($cartItem);
        return $cartItem;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $cartItem = $this->cartItemInterfaceFactory->create()->load($id, 'item_id');
        if (!$cartItem->getId()) {
            throw new NoSuchEntityException(
                __("The sms message that was requested doesn't exist.")
            );
        }
        return $cart;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->cartItemCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $items = $collection->getItems();

        /** @var \AlbertMage\Quote\Api\Data\CartItemSearchResultsInterface $searchResults */
        $searchResults = $this->cartItemSearchResultsFactory->create();
        $searchResults->setItems($items);
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
