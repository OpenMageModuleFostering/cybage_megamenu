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
class Cybage_Megamenu_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_MEGAMENU_ENABLE = 'megamenu/settings/enable';
    const XML_PATH_MEGAMENU_BACKGROUND_COLOR = 'megamenu/megamenu_configuration/background_color';
    const XML_PATH_MEGAMENU_FONT_COLOR = 'megamenu/megamenu_configuration/font_color';
    const XML_PATH_MEGAMENU_FONT_FAMILY = 'megamenu/megamenu_configuration/font_family';
    const XML_PATH_MEGAMENU_FONT_SIZE = 'megamenu/megamenu_configuration/font_size';
    const XML_PATH_MEGAMENU_MAXIMUM_CONTENT_SIZE = 'megamenu/megamenu_configuration/maximum_content_size';
    const XML_PATH_MEGAMENU_MAXIMUM_COLUMN_SIZE = 'megamenu/megamenu_configuration/maximum_column_size';

    /**
     * Check wherther it is enable or not
     *
     * @return boolean
     */
    public function isMegamenuModuleEnabled() {
        return Mage::getStoreConfig(self::XML_PATH_MEGAMENU_ENABLE);
    }

    /**
     * @return string Background Color
     */
    public function getBackgroundColor() {
        return Mage::getStoreConfig(self::XML_PATH_MEGAMENU_BACKGROUND_COLOR);
    }

    /**
     * @return string Font Color
     */
    public function getFontColor() {
        return Mage::getStoreConfig(self::XML_PATH_MEGAMENU_FONT_COLOR);
    }

    /**
     * @return string Font Family
     */
    public function getFontFamily() {
        return Mage::getStoreConfig(self::XML_PATH_MEGAMENU_FONT_FAMILY);
    }

    /**
     * @return int Font Size
     */
    public function getFontSize() {
        return Mage::getStoreConfig(self::XML_PATH_MEGAMENU_FONT_SIZE);
    }

    /**
     * @return int Maximum Content Size
     */
    public function getMaximumContentSize() {

        $contentSize = Mage::getStoreConfig(self::XML_PATH_MEGAMENU_MAXIMUM_CONTENT_SIZE);
        return (!empty($contentSize)) ? $contentSize : 800;
    }

    /**
     * @return int Maximum Column Size
     */
    public function getMaximumColumnSize() {
        $columnSize = Mage::getStoreConfig(self::XML_PATH_MEGAMENU_MAXIMUM_COLUMN_SIZE);
        return (!empty($columnSize)) ? $columnSize : 11;
    }

    function toOptionsArray($data) {
        foreach ($data as $key) {
            $newData[] = array(
                'value' => $key['entity_id'],
                'label' => $key['name']
            );
        }
        return $newData;
    }

}
