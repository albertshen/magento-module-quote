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
use AlbertMage\Quote\Api\Data\CartInterface;
use AlbertMage\Quote\Api\Data\CartInterfaceFactory;
use AlbertMage\Quote\Api\Data\CartSearchResultsInterfaceFactory;
use AlbertMage\Quote\Model\ResourceModel\Cart;
use AlbertMage\Quote\Model\ResourceModel\Cart\CollectionFactory;

/**
 * Cart repository.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CartRepository implements \AlbertMage\Quote\Api\CartRepositoryInterface
{

    /**
     * @var \AlbertMage\Quote\Model\CartFactory
     */
    protected $cartFactory;

    /**
     * @var \AlbertMage\Quote\Model\ResourceModel\Cart
     */
    protected $cartResourceModel;

    /**
     * @var \AlbertMage\Quote\Api\Data\CartSearchResultsInterfaceFactory
     */
    protected $cartSearchResultsFactory;

    /**
     * @var \AlbertMage\Quote\Model\ResourceModel\Cart\CollectionFactory
     */
    protected $cartCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param \AlbertMage\Quote\Model\CartFactory $cartFactory
     * @param \AlbertMage\Quote\Model\ResourceModel\Cart $cartResourceModel
     * @param \AlbertMage\Quote\Api\Data\CartSearchResultsInterfaceFactory $cartSearchResultsFactory
     * @param \AlbertMage\Quote\Model\ResourceModel\Cart\CollectionFactory $cartCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \AlbertMage\Quote\Model\CartFactory $cartFactory,
        \AlbertMage\Quote\Model\ResourceModel\Cart $cartResourceModel,
        \AlbertMage\Quote\Api\Data\CartSearchResultsInterfaceFactory $cartSearchResultsFactory,
        \AlbertMage\Quote\Model\ResourceModel\Cart\CollectionFactory $cartCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->cartFactory = $cartFactory;
        $this->cartResourceModel = $cartResourceModel;
        $this->cartSearchResultsFactory = $cartSearchResultsFactory;
        $this->cartCollectionFactory = $cartCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(\AlbertMage\Quote\Api\Data\CartInterface $cart)
    {
        $this->cartResourceModel->save($cart);
        return $cart;
    }

    /**
     * @inheritDoc
     */
    public function delete(\AlbertMage\Quote\Api\Data\CartInterface $cart)
    {
        $this->cartResourceModel->delete($cart);
        return $cart;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $cart = $this->cartInterfaceFactory->create()->load($id, 'entity_id');
        if (!$cart->getId()) {
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
        $collection = $this->cartCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $items = $collection->getItems();

        /** @var \AlbertMage\Quote\Api\Data\CartSearchResultsInterface $searchResults */
        $searchResults = $this->cartSearchResultsFactory->create();
        $searchResults->setItems($items);
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
