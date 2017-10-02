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
namespace Dyrecta\Beecart\Controller\Adminhtml\Renewal;

class InlineEdit extends \Dyrecta\Beecart\Controller\Adminhtml\Renewal
{
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Renewal repository
     * 
     * @var \Dyrecta\Beecart\Api\RenewalRepositoryInterface
     */
    protected $renewalRepository;

    /**
     * Page factory
     * 
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Date filter
     * 
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * Data object processor
     * 
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data object helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * Renewal resource model
     * 
     * @var \Dyrecta\Beecart\Model\ResourceModel\Renewal
     */
    protected $renewalResourceModel;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Dyrecta\Beecart\Model\ResourceModel\Renewal $renewalResourceModel
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Dyrecta\Beecart\Model\ResourceModel\Renewal $renewalResourceModel
    ) {
        $this->dataObjectProcessor  = $dataObjectProcessor;
        $this->dataObjectHelper     = $dataObjectHelper;
        $this->jsonFactory          = $jsonFactory;
        $this->renewalResourceModel = $renewalResourceModel;
        parent::__construct($context, $coreRegistry, $renewalRepository, $resultPageFactory, $dateFilter);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $renewalId) {
            /** @var \Dyrecta\Beecart\Model\Renewal|\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal */
            $renewal = $this->renewalRepository->getById((int)$renewalId);
            try {
                $renewalData = $postItems[$renewalId];
                $renewalData = $this->filterData($renewalData);
                $this->dataObjectHelper->populateWithArray($renewal, $renewalData, \Dyrecta\Beecart\Api\Data\RenewalInterface::class);
                $this->renewalResourceModel->saveAttribute($renewal, array_keys($renewalData));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithRenewalId($renewal, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithRenewalId($renewal, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithRenewalId(
                    $renewal,
                    __('Something went wrong while saving the Renewal.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Renewal id to error message
     *
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithRenewalId(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal, $errorText)
    {
        return '[Renewal ID: ' . $renewal->getId() . '] ' . $errorText;
    }
}
