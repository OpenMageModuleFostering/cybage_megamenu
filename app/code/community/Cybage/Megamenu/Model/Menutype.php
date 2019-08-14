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
