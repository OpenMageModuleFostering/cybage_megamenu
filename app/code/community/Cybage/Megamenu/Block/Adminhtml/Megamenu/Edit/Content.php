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
