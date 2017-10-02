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

class Delete extends \Dyrecta\Beecart\Controller\Adminhtml\Renewal
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('renewal_id');
        if ($id) {
            try {
                $this->renewalRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The Renewal has been deleted.'));
                $resultRedirect->setPath('dyrecta_beecart/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The Renewal no longer exists.'));
                return $resultRedirect->setPath('dyrecta_beecart/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('dyrecta_beecart/renewal/edit', ['renewal_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the Renewal'));
                return $resultRedirect->setPath('dyrecta_beecart/renewal/edit', ['renewal_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Renewal to delete.'));
        $resultRedirect->setPath('dyrecta_beecart/*/');
        return $resultRedirect;
    }
}
