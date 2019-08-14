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
class Cybage_Megamenu_Model_Menutemplate extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/menutemplate');
    }

    /**
     * return template based on selected menu type;
     * @param type $id
     * @return type array
     */
    public function filterTtemplate($id) {

        $templateList = parent::getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToSelect('name')
                ->addFieldToFilter('type_id', array(array('eq' => $id)));
        return $templateList->getData();
    }

    /**
     * 
     * @param type $templateId
     * @return type string
     */
    public function getImage($templateId) {

        $templateData = parent::load($templateId);
        return $templateData->getLayoutImage();
    }

}
