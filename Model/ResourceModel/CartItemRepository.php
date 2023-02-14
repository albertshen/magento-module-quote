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
     * @var \AlbertMage\Quote\Api\Data\CartItemInterfaceFactory
     */
    protected $cartItemInterfaceFactory;

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
     * @param \AlbertMage\Quote\Api\Data\CartItemInterfaceFactory $cartItemInterfaceFactory
     * @param \AlbertMage\Quote\Model\ResourceModel\CartItem $cartItemResourceModel
     * @param \AlbertMage\Quote\Api\Data\CartItemSearchResultsInterfaceFactory $cartItemSearchResultsFactory
     * @param \AlbertMage\Quote\Model\ResourceModel\CartItem\CollectionFactory $cartItemCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \AlbertMage\Quote\Api\Data\CartItemInterfaceFactory $cartItemInterfaceFactory,
        \AlbertMage\Quote\Model\ResourceModel\CartItem $cartItemResourceModel,
        \AlbertMage\Quote\Api\Data\CartItemSearchResultsInterfaceFactory $cartItemSearchResultsFactory,
        \AlbertMage\Quote\Model\ResourceModel\CartItem\CollectionFactory $cartItemCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->cartItemInterfaceFactory = $cartItemInterfaceFactory;
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

    /**
     * Retrieve cart item.
     *
     * @param int $cartId
     * @param int $productId
     * @return CartItemInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOneByProductId($cartId, $productId)
    {
        /** @var Collection $collection */
        $collection = $this->cartItemCollectionFactory->create();
        $collection->addFieldToFilter('cart_id', ['eq' => $cartId]);
        $collection->addFieldToFilter('product_id', ['eq' => $productId]);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return $this->cartItemInterfaceFactory->create();
    }

    /**
     * Retrieve cart items.
     *
     * @param int $cartId
     * @return \AlbertMage\Quote\Model\ResourceModel\CartItem\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByCartId($cartId)
    {
        $collection = $this->cartItemCollectionFactory->create();
        $collection->addFieldToFilter('cart_id', ['eq' => $cartId]);
        return $collection;
    }

}
