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

/**
 * @method \Dyrecta\Beecart\Model\ResourceModel\Renewal _getResource()
 * @method \Dyrecta\Beecart\Model\ResourceModel\Renewal getResource()
 */
class Renewal extends \Magento\Framework\Model\AbstractModel implements \Dyrecta\Beecart\Api\Data\RenewalInterface
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'dyrecta_beecart_renewal';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'dyrecta_beecart_renewal';

    /**
     * Event object
     * 
     * @var string
     */
    protected $_eventObject = 'renewal';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Dyrecta\Beecart\Model\ResourceModel\Renewal::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Renewal id
     *
     * @return array
     */
    public function getRenewalId()
    {
        return $this->getData(\Dyrecta\Beecart\Api\Data\RenewalInterface::RENEWAL_ID);
    }

    /**
     * set Renewal id
     *
     * @param int $renewalId
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     */
    public function setRenewalId($renewalId)
    {
        return $this->setData(\Dyrecta\Beecart\Api\Data\RenewalInterface::RENEWAL_ID, $renewalId);
    }

    /**
     * set Date
     *
     * @param mixed $date
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     */
    public function setDate($date)
    {
        return $this->setData(\Dyrecta\Beecart\Api\Data\RenewalInterface::DATE, $date);
    }

    /**
     * get Date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->getData(\Dyrecta\Beecart\Api\Data\RenewalInterface::DATE);
    }

    /**
     * set Status
     *
     * @param mixed $status
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     */
    public function setStatus($status)
    {
        return $this->setData(\Dyrecta\Beecart\Api\Data\RenewalInterface::STATUS, $status);
    }

    /**
     * get Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(\Dyrecta\Beecart\Api\Data\RenewalInterface::STATUS);
    }

    /**
     * set Expiration_date
     *
     * @param mixed $expirationDate
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     */
    public function setExpirationDate($expirationDate)
    {
        return $this->setData(\Dyrecta\Beecart\Api\Data\RenewalInterface::EXPIRATION_DATE, $expirationDate);
    }

    /**
     * get Expiration_date
     *
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->getData(\Dyrecta\Beecart\Api\Data\RenewalInterface::EXPIRATION_DATE);
    }

    /**
     * set Name
     *
     * @param mixed $name
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface
     */
    public function setName($name)
    {
        return $this->setData(\Dyrecta\Beecart\Api\Data\RenewalInterface::NAME, $name);
    }

    /**
     * get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(\Dyrecta\Beecart\Api\Data\RenewalInterface::NAME);
    }
}
