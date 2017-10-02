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

class Save extends \Dyrecta\Beecart\Controller\Adminhtml\Renewal
{
    /**
     * Renewal factory
     * 
     * @var \Dyrecta\Beecart\Api\Data\RenewalInterfaceFactory
     */
    protected $renewalFactory;

    /**
     * Data Object Processor
     * 
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data Object Helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Uploader pool
     * 
     * @var \Dyrecta\Beecart\Model\UploaderPool
     */
    protected $uploaderPool;

    /**
     * Data Persistor
     * 
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterfaceFactory $renewalFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Dyrecta\Beecart\Model\UploaderPool $uploaderPool
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Dyrecta\Beecart\Api\Data\RenewalInterfaceFactory $renewalFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Dyrecta\Beecart\Model\UploaderPool $uploaderPool,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->renewalFactory      = $renewalFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper    = $dataObjectHelper;
        $this->uploaderPool        = $uploaderPool;
        $this->dataPersistor       = $dataPersistor;
        parent::__construct($context, $coreRegistry, $renewalRepository, $resultPageFactory, $dateFilter);
    }

    /**
     * run the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal */
        $renewal = null;
        $postData = $this->getRequest()->getPostValue();
        $data = $postData;
        $data = $this->filterData($data);
        $id = !empty($data['renewal_id']) ? $data['renewal_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $renewal = $this->renewalRepository->getById((int)$id);
            } else {
                unset($data['renewal_id']);
                $renewal = $this->renewalFactory->create();
            }
            $this->dataObjectHelper->populateWithArray($renewal, $data, \Dyrecta\Beecart\Api\Data\RenewalInterface::class);
            $this->renewalRepository->save($renewal);
            $this->messageManager->addSuccessMessage(__('You saved the Renewal'));
            $this->dataPersistor->clear('dyrecta_beecart_renewal');
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('dyrecta_beecart/renewal/edit', ['renewal_id' => $renewal->getId()]);
            } else {
                $resultRedirect->setPath('dyrecta_beecart/renewal');
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('dyrecta_beecart_renewal', $postData);
            $resultRedirect->setPath('dyrecta_beecart/renewal/edit', ['renewal_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the Renewal'));
            $this->dataPersistor->set('dyrecta_beecart_renewal', $postData);
            $resultRedirect->setPath('dyrecta_beecart/renewal/edit', ['renewal_id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param string $type
     * @return \Dyrecta\Beecart\Model\Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
