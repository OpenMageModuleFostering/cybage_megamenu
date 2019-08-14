<?php

/**
 * megamenu menuattribute values model save attrubute values
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Model_Menuattributevalues extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/menuattributevalues');
    }

    /**
     * save attrubute values 
     * @param type $menuId
     * @param type $mappingId
     * @param type $value
     * @return type
     */
    public function saveValue($menuId, $mappingId, $value) {

        // check if old value exists for this record
        $vaild = $this->validate($menuId, $mappingId, $value);
        // save value if valid returns 0
        if ($vaild == 0) {
            try{
                parent::setData(
                    array(
                        'template_attribute_id' => $mappingId,
                        'menu_id' => $menuId,
                        'value' => $value,
                        'created_time' => now(),
                        'update_time' => now()));
                    parent::save();
            }catch(Exception $e){
                Mage::log($e);
            }
            
        }
    }

    /**
     * update if record found
     * @param type $menuId
     * @param type $mappingId
     * @param type $value
     * @return int
     */
    public function validate($menuId, $mappingId, $value) {
        $collection = parent::getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter('template_attribute_id', array(array('eq' => $mappingId)))
                ->addFieldToFilter('menu_id', array(array('eq' => $menuId)));
        $data = $collection->getData();
        if (count($data) > 0) {
            $entityId = $data[0]['entity_id'];
            try{
                $rowData = parent::load($entityId);
                $rowData->setValue($value);
                $rowData->save();
                return 1;
            }catch(Exception $e){
                Mage::log($e);
            }
        } else {
            return 0;
        }
    }

    /**
     * skip comman attribute values and send other for saving purpose from post data
     * @param type $menuId
     * @param type $data
     */
    public function processData($menuId, $data) {


        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $continuearray = array(
                    'form_key','name','store_id','status','type_id','template_id',
                    'header','footer','menu_icon'
                );
                if (in_array($key, $continuearray)) {
                    continue;
                } else {
                    $typeId = $data['type_id'];
                    $templateId = $data['template_id'];
                    $attributeId = Mage::getModel('megamenu/attributes')->getAttributeId($key);
                    $mappingId = Mage::getModel('megamenu/menuattributes')
                            ->getMappingId($attributeId, $templateId);

                    if (trim($mappingId) != '') {
                        Mage::getModel('megamenu/menuattributevalues')->saveValue($menuId, $mappingId, $value);
                    }
                }
            }
        }
    }

}
