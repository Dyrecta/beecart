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

class Edit extends \Dyrecta\Beecart\Controller\Adminhtml\Renewal
{
    /**
     * Initialize current Renewal and set it in the registry.
     *
     * @return int
     */
    protected function initRenewal()
    {
        $renewalId = $this->getRequest()->getParam('renewal_id');
        $this->coreRegistry->register(\Dyrecta\Beecart\Controller\RegistryConstants::CURRENT_RENEWAL_ID, $renewalId);

        return $renewalId;
    }

    /**
     * Edit or create Renewal
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $renewalId = $this->initRenewal();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dyrecta_Beecart::beecart_renewal');
        $resultPage->getConfig()->getTitle()->prepend(__('Renewals'));
        $resultPage->addBreadcrumb(__('Beecart'), __('Beecart'));
        $resultPage->addBreadcrumb(__('Renewals'), __('Renewals'), $this->getUrl('dyrecta_beecart/renewal'));

        if ($renewalId === null) {
            $resultPage->addBreadcrumb(__('New Renewal'), __('New Renewal'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Renewal'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Renewal'), __('Edit Renewal'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->renewalRepository->getById($renewalId)->getName()
            );
        }
        return $resultPage;
    }
}
