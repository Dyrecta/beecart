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
namespace Dyrecta\Beecart\Api\Data;

/**
 * @api
 */
interface RenewalInterface
{
    /**
     * ID
     * 
     * @var string
     */
    const RENEWAL_ID = 'renewal_id';

    /**
     * Date attribute constant
     * 
     * @var string
     */
    const DATE = 'date';

    /**
     * Status attribute constant
     * 
     * @var string
     */
    const STATUS = 'status';

    /**
     * Expiration_date attribute constant
     * 
     * @var string
     */
    const EXPIRATION_DATE = 'expiration_date';

    /**
     * Name attribute constant
     * 
     * @var string
     */
    const NAME = 'name';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getRenewalId();

    /**
     * Set ID
     *
     * @param int $renewalId
     * @return RenewalInterface
     */
    public function setRenewalId($renewalId);

    /**
     * Get Date
     *
     * @return mixed
     */
    public function getDate();

    /**
     * Set Date
     *
     * @param mixed $date
     * @return RenewalInterface
     */
    public function setDate($date);

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param mixed $status
     * @return RenewalInterface
     */
    public function setStatus($status);

    /**
     * Get Expiration_date
     *
     * @return mixed
     */
    public function getExpirationDate();

    /**
     * Set Expiration_date
     *
     * @param mixed $expirationDate
     * @return RenewalInterface
     */
    public function setExpirationDate($expirationDate);

    /**
     * Get Name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Set Name
     *
     * @param mixed $name
     * @return RenewalInterface
     */
    public function setName($name);
}
