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

$installer->run("ALTER TABLE {$this->getTable('megamenu_main')}  "
        . "ADD `menu_order` INT NOT NULL  AFTER `is_active`,  ADD   UNIQUE  (`menu_order`) ;");

$installer->endSetup();
