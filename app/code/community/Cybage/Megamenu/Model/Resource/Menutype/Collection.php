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
class Cybage_Megamenu_Model_Resource_Menutype_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/menutype');
    }

}
