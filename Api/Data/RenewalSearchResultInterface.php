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
interface RenewalSearchResultInterface
{
    /**
     * Get Renewals list.
     *
     * @return \Dyrecta\Beecart\Api\Data\RenewalInterface[]
     */
    public function getItems();

    /**
     * Set Renewals list.
     *
     * @param \Dyrecta\Beecart\Api\Data\RenewalInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
