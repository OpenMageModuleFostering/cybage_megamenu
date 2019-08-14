<?php
/**
* Cybage Megamenu Plugin
*
* @category   Megamenu Plugin
* @package    Cybage_Megamenu
* @copyright  Copyright (c) 2015 Cybage Software Pvt. Ltd., India
*             http://www.cybage.com/coe/e-commerce
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @author     Cybage Software Pvt. Ltd. 
 */
$installer = $this;

$installer->startSetup();

$installer->run("UPDATE {$this->getTable('megamenu_type')} SET `is_active` = '0' WHERE `megamenu_type`.`entity_id` = 3;");
//$installer->run("UPDATE {$this->getTable('megamenu_type')} "
//. "SET `is_active` = '0' WHERE `entity_id` = '3';");

$installer->endSetup();

