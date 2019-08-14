<?php

/**
 * Cybage Rewardpoint Plugin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available on the World Wide Web at:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to access it on the World Wide Web, please send an email
 * To: Support_Magento@cybage.com.  We will send you a copy of the source file.
 *
 * @category   Rewardpoint Plugin
 * @package    Cybage_Rewardpoint
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 */
$installer = $this;

$installer->startSetup();

$installer->run("UPDATE {$this->getTable('megamenu_type')} SET `is_active` = '0' WHERE `megamenu_type`.`entity_id` = 3;");
//$installer->run("UPDATE {$this->getTable('megamenu_type')} "
//. "SET `is_active` = '0' WHERE `entity_id` = '3';");

$installer->endSetup();

