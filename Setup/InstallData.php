<?php
/* app/code/Atwix/TestAttribute/Setup/InstallData.php */

namespace Dyrecta\Beecart\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Api\AttributeRepositoryInterface; 
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory, 
        AttributeRepositoryInterface $attributeRepository

    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
                $this->attributeRepository = $attributeRepository;

    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $file = __FILE__; 
        $file = dirname($file). "/beecart_start_data.sql" ; 
        $querys = file_get_contents($file); 
        try{
            $connection->beginTransaction(); 
            $querys = explode(";", $querys); 
            foreach ($querys as $query) {
                //$connection->query($query);     
            }
            $connection->commit();
        } catch (\Exception $e) {
            // Rollback transaction
            $connection->rollBack();
            throw $e; 
        } 


        

        //$DirectoryList = $objectManager->get('Magento\Framework\App\Filesystem\DirectoryList');
        //$mediapath=$DirectoryList->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        //$mediapath = ."/Dyrecta/Beecart/"."config.json"; 
        
        $json = file_get_contents("/home/domotica.json"); 
        $json = json_decode($json,true); 
        $resourceConfig = $objectManager->get('Magento\Config\Model\ResourceModel\Config');
        foreach ($json as $key => $value) {
            $resourceConfig->saveConfig($key,$value['value'],   $value['scope'],    $value['scope_id']);
        }
        /*






        $resourceConfig->saveConfig(    'general/country/default'                   ,'IT'           ,   'default',  0);
        $resourceConfig->saveConfig(    'general/locale/timezone'                   ,'Europe/Rome'  ,   'default',  0);
        $resourceConfig->saveConfig(    'general/locale/code'                       ,'IT'           ,   'default',  0);
        $resourceConfig->saveConfig(    'general/country/default'                   ,'IT'           ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/name'            ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/phone'           ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/hours'           ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/country_id'      ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/region_id'       ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/postcode'        ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/city'            ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/street_line1'    ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'general/store_information/street_line2'    ,''     ,   'default',  0);
        $resourceConfig->saveConfig(    'currency/options/base'                     ,'EUR'  ,   'default',  0);
        $resourceConfig->saveConfig(    'currency/options/default'                  ,'EUR'  ,   'default',  0);
        $resourceConfig->saveConfig(    'currency/options/allow'                    ,'EUR'  ,   'default',  0);
        $resourceConfig->saveConfig(    'contact/email/recipient_email'             ,'EUR'  ,   'default',  0);

        */

    }
}