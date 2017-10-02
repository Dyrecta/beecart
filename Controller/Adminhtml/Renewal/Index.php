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

class Index extends \Dyrecta\Beecart\Controller\Adminhtml\Renewal
{
    /**
     * Renewals list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dyrecta_Beecart::renewal');
        $resultPage->getConfig()->getTitle()->prepend(__('Renewals'));
        $resultPage->addBreadcrumb(__('Beecart'), __('Beecart'));
        $resultPage->addBreadcrumb(__('Renewals'), __('Renewals'));
        return $resultPage;
    }
}
