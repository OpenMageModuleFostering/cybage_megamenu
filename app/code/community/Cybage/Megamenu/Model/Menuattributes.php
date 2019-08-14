<?php

/**
 * megamenu menuattributes model return mapping id 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Model_Menuattributes extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/menuattributes');
    }

    /**
     * 
     * @param type $attributeId
     * @param type $templateId
     * @return string
     */
    public function getMappingId($attributeId, $templateId) {
        $collection = parent::getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter('attribute_id', array(array('eq' => $attributeId)))
                ->addFieldToFilter('template_id', array(array('eq' => $templateId)));
        $data = $collection->getData();
        if (count($data) > 0) {
            return $data[0]['entity_id'];
        } else {
            return " ";
        }
    }

}
