<?php
/**
 * megamenu status model
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
 
class Cybage_Megamenu_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('megamenu')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('megamenu')->__('Disabled')
        );
    }
}