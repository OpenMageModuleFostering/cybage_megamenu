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
class Cybage_Megamenu_Block_Adminhtml_Megamenu extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     *  Initializing menamenu Grid View
     */
    public function __construct() {
        $this->_controller = 'adminhtml_megamenu';
        $this->_blockGroup = 'megamenu';
        $this->_headerText = Mage::helper('megamenu')->__('Menu Item Manager');
        $this->_addButtonLabel = Mage::helper('megamenu')->__('Add Menu Item');
        parent::__construct();
    }

    /**
     * return categories
     * @return type object
     */
    public function getCategories() {
        $rootCatId = Mage::app()->getWebsite(true)->getDefaultStore()->getRootCategoryId();
        $catlistHtml = $this->getTreeCategories($rootCatId, false);
        return $catlistHtml;
    }

}
