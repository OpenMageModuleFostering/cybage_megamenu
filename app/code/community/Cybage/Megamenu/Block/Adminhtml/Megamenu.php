<?php

/**
 * return's the category tree  
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
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
