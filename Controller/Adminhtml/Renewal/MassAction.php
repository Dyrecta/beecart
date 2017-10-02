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

abstract class MassAction extends \Magento\Backend\App\Action
{
    /**
     * Renewal repository
     * 
     * @var \Dyrecta\Beecart\Api\RenewalRepositoryInterface
     */
    protected $renewalRepository;

    /**
     * Mass Action filter
     * 
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Renewal collection factory
     * 
     * @var \Dyrecta\Beecart\Model\ResourceModel\Renewal\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Action success message
     * 
     * @var string
     */
    protected $successMessage;

    /**
     * Action error message
     * 
     * @var string
     */
    protected $errorMessage;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Dyrecta\Beecart\Model\ResourceModel\Renewal\CollectionFactory $collectionFactory
     * @param string $successMessage
     * @param string $errorMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Dyrecta\Beecart\Model\ResourceModel\Renewal\CollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        $this->renewalRepository = $renewalRepository;
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->successMessage    = $successMessage;
        $this->errorMessage      = $errorMessage;
        parent::__construct($context);
    }

    /**
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @return mixed
     */
    abstract protected function massAction(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal);

    /**
     * execute action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $renewal) {
                $this->massAction($renewal);
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, $this->errorMessage);
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('dyrecta_beecart/*/index');
        return $redirectResult;
    }
}
