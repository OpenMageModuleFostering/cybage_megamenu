<?php

/**
 * megamenu menutype model
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Model_Menutype extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/menutype');
    }

    /**
     * Return menu typle list for select 
     * @return array
     */
    public function getMenuList() {
        $menuTypes = parent::getCollection();
        $menuTypes->addFieldToFilter('is_active', 1);
        $menuAarray[] = array('value' => '', 'label' => "Select menu type");
        foreach ($menuTypes as $menu) {
            $menuAarray[] = array('value' => $menu->getId(), 'label' => $menu->getType());
        }
        return $menuAarray;
    }

}
