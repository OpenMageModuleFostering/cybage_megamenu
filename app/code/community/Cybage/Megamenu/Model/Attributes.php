<?php

/**
 * megamenu attributes model return  attributeId and it's value  
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Model_Attributes extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/attributes');
    }

    /**
     * 
     * @param type $attribute
     * @return type Int
     */
    public function getAttributeId($attribute) {

        $collection = parent::getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter('atribute_code', array(array('eq' => $attribute)));
        $data = $collection->getData();
        foreach ($data as $row) {
            return $row['entity_id'];
        }
    }

    /**
     * append attribute values to data array and return array
     * @param type $id
     * @param type $data
     * @return type array
     */
    public function getValues($id, $data) {

        $collection = parent::getCollection();
        $collection->addFieldToSelect('atribute_code');
        $collection->getSelect()->joinLeft(array('mapping' => 'megamenu_template_attributes'), 'main_table.entity_id = mapping.attribute_id', array());
        $collection->getSelect()->joinLeft(array('attributeValues' => 'megamenu_template_attributes_values'), 'mapping.entity_id = attributeValues.template_attribute_id', array('attributeValues.value'));
        $collection->getSelect()->where('attributeValues.menu_id=?', $id);



        foreach ($collection->getData() as $row) {

            $key = $row['atribute_code'];
            $val = $row['value'];
            $data[$key] = $val;
        }

        return $data;
    }

}
