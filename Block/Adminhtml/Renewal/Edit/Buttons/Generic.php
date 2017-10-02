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
namespace Dyrecta\Beecart\Block\Adminhtml\Renewal\Edit\Buttons;

class Generic
{
    /**
     * Widget Context
     * 
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;

    /**
     * Renewal Repository
     * 
     * @var \Dyrecta\Beecart\Api\RenewalRepositoryInterface
     */
    protected $renewalRepository;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Dyrecta\Beecart\Api\RenewalRepositoryInterface $renewalRepository
    ) {
        $this->context           = $context;
        $this->renewalRepository = $renewalRepository;
    }

    /**
     * Return Renewal ID
     *
     * @return int|null
     */
    public function getRenewalId()
    {
        try {
            return $this->renewalRepository->getById(
                $this->context->getRequest()->getParam('renewal_id')
            )->getId();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
