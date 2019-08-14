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
