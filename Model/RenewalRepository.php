<?php
/**
 * Dyrecta_Beecart extension
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category  Dyrecta
 * @package   Dyrecta_Beecart
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 */
namespace Dyrecta\Beecart\Model;

class RenewalRepository implements \Dyrecta\Beecart\Api\RenewalRepositoryInterface
{
    /**
     * Cached instances
     * 
     * @var array
     */
    protected $instances = [];

    /**
     * Renewal resource model
     * 
     * @var \Dyrecta\Beecart\Model\ResourceModel\Renewal
     */
    protected $resource;

    /**
     * Renewal collection factory
     * 
     * @var \Dyrecta\Beecart\Model\ResourceModel\Renewal\CollectionFactory
     */
    protected $renewalCollectionFactory;

    /**
     * Renewal interface factory
     * 
     * @var \Dyrecta\Beecart\Api\Data\RenewalInterfaceFactory
     */
    protected $renewalInterfaceFactory;

    /**
     * Data Object Helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     * 
     * @var \Dyrecta\Beecart\Api\Data\RenewalSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * constructor
     * 
     * @param \Dyrecta\Beecart\Model\ResourceModel\Renewal $resource
     * @param \Dyrecta\Beecart\Model\ResourceModel\Renewal\CollectionFactory $renewalCollectionFactory
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterfaceFactory $renewalInterfaceFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Dyrecta\Beecart\Api\Data\RenewalSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Dyrecta\Beecart\Model\ResourceModel\Renewal $resource,
        \Dyrecta\Beecart\Model\ResourceModel\Renewal\CollectionFactory $renewalCollectionFactory,
        \Dyrecta\Beecart\Api\Data\RenewalInterfaceFactory $renewalInterfaceFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Dyrecta\Beecart\Api\Data\RenewalSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->resource                 = $resource;
        $this->renewalCollectionFactory = $renewalCollectionFactory;
        $this->renewalInterfaceFactory  = $renewalInterfaceFactory;
        $this->dataObjectHelper         = $dataObjectHelper;
        $this->searchResultsFactory     = $searchResultsFactory;
    }

    /**
     * Save Renewal.
     *
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal)
    {
        /** @var \Dyrecta\Beecart\Api\Data\RenewalInterface|\Magento\Framework\Model\AbstractModel $renewal */
        try {
            $this->resource->save($renewal);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(
                'Could not save the Renewal: %1',
                $exception->getMessage()
            ));
        }
        return $renewal;
    }

    /**
     * Retrieve Renewal.
     *
     * @param int $renewalId
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($renewalId)
    {
        if (!isset($this->instances[$renewalId])) {
            /** @var \Dyrecta\Beecart\Api\Data\RenewalInterface|\Magento\Framework\Model\AbstractModel $renewal */
            $renewal = $this->renewalInterfaceFactory->create();
            $this->resource->load($renewal, $renewalId);
            if (!$renewal->getId()) {
                throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested Renewal doesn\'t exist'));
            }
            $this->instances[$renewalId] = $renewal;
        }
        return $this->instances[$renewalId];
    }

    /**
     * Retrieve Renewals matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dyrecta\Beecart\Api\Data\RenewalSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Dyrecta\Beecart\Api\Data\RenewalSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Dyrecta\Beecart\Model\ResourceModel\Renewal\Collection $collection */
        $collection = $this->renewalCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var \Magento\Framework\Api\Search\FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'renewal_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var \Dyrecta\Beecart\Api\Data\RenewalInterface[] $renewals */
        $renewals = [];
        /** @var \Dyrecta\Beecart\Model\Renewal $renewal */
        foreach ($collection as $renewal) {
            /** @var \Dyrecta\Beecart\Api\Data\RenewalInterface $renewalDataObject */
            $renewalDataObject = $this->renewalInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $renewalDataObject,
                $renewal->getData(),
                \Dyrecta\Beecart\Api\Data\RenewalInterface::class
            );
            $renewals[] = $renewalDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($renewals);
    }

    /**
     * Delete Renewal.
     *
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal)
    {
        /** @var \Dyrecta\Beecart\Api\Data\RenewalInterface|\Magento\Framework\Model\AbstractModel $renewal */
        $id = $renewal->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($renewal);
        } catch (\Magento\Framework\Exception\ValidatorException $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Unable to remove Renewal %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * Delete Renewal by ID.
     *
     * @param int $renewalId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($renewalId)
    {
        $renewal = $this->getById($renewalId);
        return $this->delete($renewal);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Dyrecta\Beecart\Model\ResourceModel\Renewal\Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Dyrecta\Beecart\Model\ResourceModel\Renewal\Collection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }
}
