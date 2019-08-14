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
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * 
     * @return type Parent Function Object
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('megamenu_form', array('legend' => Mage::helper('megamenu')->__('General information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('megamenu')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));
        $fieldset->addField('titel', 'text', array(
            'label' => Mage::helper('megamenu')->__('Title'),
            'name' => 'titel',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'store_id[]',
                'label' => Mage::helper('megamenu')->__('Store View'),
                'title' => Mage::helper('megamenu')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')
                        ->getStoreValuesForForm(false, true),
            ));
            $renderer = $this->getLayout()
                    ->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'store_id[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('megamenu')->__('Status'),
            'name' => 'is_active',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('megamenu')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('megamenu')->__('Disabled'),
                ),
            ),
        ));

        $fieldset->addField('menu_order', 'text', array(
            'label' => Mage::helper('megamenu')->__('Order'),
            'class' => 'required-entry validate-digits',
            'required' => true,
            'name' => 'order',
        ));

        if (Mage::getSingleton('adminhtml/session')->getMegamenuData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMegamenuData());
            Mage::getSingleton('adminhtml/session')->setMegamenuData(null);
        } elseif (Mage::registry('megamenu_data')) {
            $getData = Mage::registry('megamenu_data')->getData();
            if ($this->getRequest()->getParam('id')) {
                $id = $this->getRequest()->getParam('id');
                $newData = Mage::getModel('megamenu/stores')->getStores($id, $getData);
                $form->setValues($newData);
            } else {
                if (!$form->getStoreId()) {
                    Mage::registry('megamenu_data')->setData('store_id', Mage::app()->getStore(true)->getId());
                }
                $form->setValues(Mage::registry('megamenu_data')->getData());
            }
        }
        return parent::_prepareForm();
    }

}
