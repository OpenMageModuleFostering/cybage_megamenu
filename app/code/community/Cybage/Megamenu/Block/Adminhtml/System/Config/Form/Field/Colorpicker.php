<?php

/**
 * return's the category tree html 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  11-May-2015 04:28 PM [IST]
 * @modified_at 11-May-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Block_Adminhtml_System_Config_Form_Field_Colorpicker extends Mage_Adminhtml_Block_System_Config_Form_Field {

    /**
     * Generate HTML code for color picker
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {

        $html = '<script type="text/javascript" src="' . Mage::getBaseUrl('js') . 'megamenu/systemcolorpicker/procolor-1.0/procolor.compressed.js' . '"></script>';

        // Use Varien text element as a basis
        $input = new Varien_Data_Form_Element_Text();

        // Set data from config element on Varien text element
        $input->setForm($element->getForm())
                ->setElement($element)
                ->setValue($element->getValue())
                ->setHtmlId($element->getHtmlId())
                ->setName($element->getName())
                ->setStyle('width: 60px') // Update style in order to shrink width
                ->addClass('validate-hex'); // Add some Prototype validation to make sure color code is correct
        // Inject uddated Varien text element HTML in our current HTML
        $html .= $input->getHtml();

        // Inject Procolor JS code to display color picker
        $html .= $this->_getProcolorJs($element->getHtmlId());

        // Inject Prototype validation
        //$html .= $this->_addHexValidator();

        return $html;
    }

    /**
     * Procolor JS code to display color picker
     * 
     * @param string $htmlId
     * @return string
     */
    protected function _getProcolorJs($htmlId) {
        return '<script type="text/javascript">ProColor.prototype.attachButton(\'' . $htmlId . '\', { imgPath:\'' . Mage::getBaseUrl('js') . 'megamenu/systemcolorpicker/procolor-1.0/' . 'img/procolor_win_\', showInField: true });</script>';
    }

    /**
     * Prototype validation
     *
     * @return string
     */
    protected function _addHexValidator() {
        return '<script type="text/javascript">Validation.add(\'validate-hex\', \'' . $this->__('Please enter a valid hex color code') . '\', function(v) {
				return /^#(?:[0-9a-fA-F]{3}){1,2}$/.test(v);
			});</script>';
    }

}
