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
class Cybage_Megamenu_Model_Observer {

    public function addHandler(Varien_Event_Observer $observer) {

        /* @var $update Mage_Core_Model_Layout_Update */
        $update = $observer->getEvent()->getLayout()->getUpdate();
        $update->addHandle('editor');
    }

    /**
     * Add refresh buttion in admin menu management section
     * @param type $observer
     * @return \Cybage_Megamenu_Model_Observer
     */
    public function addButtonRefresh($observer) {
        $container = $observer->getBlock();
        $url = Mage::helper('adminhtml')->getUrl('*/*/clearCache');
        if (null !== $container && $container->getType() == 'megamenu/adminhtml_megamenu') {
            $data = array(
                'label' => 'Refresh Menu Cache',
                'class' => 'some-class',
                'onclick' => 'setLocation(\'' . $url . '\')',
            );
            $container->addButton('refresh_cache', $data);
        }
    }

}
