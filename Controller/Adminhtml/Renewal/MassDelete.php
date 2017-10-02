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

class MassDelete extends \Dyrecta\Beecart\Controller\Adminhtml\Renewal\MassAction
{
    /**
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @return $this
     */
    protected function massAction(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal)
    {
        $this->renewalRepository->delete($renewal);
        return $this;
    }
}
