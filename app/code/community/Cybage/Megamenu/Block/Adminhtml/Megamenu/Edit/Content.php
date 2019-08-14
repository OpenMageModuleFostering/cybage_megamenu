<?php

/**
 * megamenu menu edit form content
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Edit_Content extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * 
     * @return type Parent Function Object
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_content_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))
            ),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
                )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
