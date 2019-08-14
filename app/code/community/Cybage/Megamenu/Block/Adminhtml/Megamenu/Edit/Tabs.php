<?php

/**
 * megamenu admin tab 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('megamenu_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('megamenu')->__('Menu Item Information'));
    }

    /**
     * 
     * @return type Parent Constructor Object
     */
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('megamenu')->__('General Information'),
            'title' => Mage::helper('megamenu')->__('General Information'),
            'content' => $this->getLayout()
                    ->createBlock('megamenu/adminhtml_megamenu_edit_tab_form')
                    ->toHtml(),
        ));


        $this->addTab('content_section', array(
            'label' => Mage::helper('megamenu')->__('Content'),
            'title' => Mage::helper('megamenu')->__('Content'),
            'content' => $this->getLayout()
                    ->createBlock('megamenu/adminhtml_megamenu_edit_tab_content')
                    ->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
