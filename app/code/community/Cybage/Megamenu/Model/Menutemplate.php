<?php

/**
 * megamenu menutemplate model return template based on selected menu type
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
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
