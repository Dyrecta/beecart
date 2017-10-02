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
namespace Dyrecta\Beecart\Api;

/**
 * @api
 */
interface RenewalRepositoryInterface
{
    /**
     * Save Renewal.
     *
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal);

    /**
     * Retrieve Renewal
     *
     * @param int $renewalId
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($renewalId);

    /**
     * Retrieve Renewals matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dyrecta\Beecart\Api\Data\RenewalSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Renewal.
     *
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface $renewal
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Dyrecta\Beecart\Api\Data\RenewalInterface $renewal);

    /**
     * Delete Renewal by ID.
     *
     * @param int $renewalId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($renewalId);
}
