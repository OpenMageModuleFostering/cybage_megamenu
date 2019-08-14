<?php
/**
 * megamenu menutemplate model 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
 
class Cybage_Megamenu_Model_Resource_Menutemplate extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('megamenu/menutemplate', 'entity_id');
    }
}