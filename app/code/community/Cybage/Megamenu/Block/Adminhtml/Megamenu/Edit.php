<?php

/**
 * megamenu add/edit menu items form header 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'megamenu';
        $this->_controller = 'adminhtml_megamenu';

        $this->_updateButton('save', 'label', Mage::helper('megamenu')->__('Save Menu Item'));
        $this->_updateButton('delete', 'label', Mage::helper('megamenu')->__('Delete Menu Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('megamenu_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'megamenu_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'megamenu_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Generating Header Text
     * @return type String
     */
    public function getHeaderText() {
        if (Mage::registry('megamenu_data') && Mage::registry('megamenu_data')->getId()) {
            return Mage::helper('megamenu')->__("Edit Menu '%s'", $this->htmlEscape(Mage::registry('megamenu_data')->getName()));
        } else {
            return Mage::helper('megamenu')->__('Add Menu');
        }
    }

}
