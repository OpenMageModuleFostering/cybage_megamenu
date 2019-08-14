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
