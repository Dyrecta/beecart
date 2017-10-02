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

class UploaderPool
{
    /**
     * Available Uploaders
     * 
     * @var array
     */
    protected $uploaders = [];

    /**
     * constructor
     * 
     * @param array $uploaders
     */
    public function __construct(
        array $uploaders = []
    ) {
        $this->uploaders = $uploaders;
    }

    /**
     * @param string $type
     * @return \Dyrecta\Beecart\Model\Uploader
     * @throws \Exception
     */
    public function getUploader($type)
    {
        if (!isset($this->uploaders[$type])) {
            throw new \Exception("Uploader not found for type: ".$type);
        }
        $uploader = $this->uploaders[$type];
        if (!($uploader instanceof \Dyrecta\Beecart\Model\Uploader)) {
            throw new \Exception("Uploader for type {$type} not instance of ". \Dyrecta\Beecart\Model\Uploader::class);
        }
        return $uploader;
    }
}
