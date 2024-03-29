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
