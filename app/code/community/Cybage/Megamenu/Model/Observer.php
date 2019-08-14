<?php

/**
 * megamenu observer resnders cache refresh button on menu item grid
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
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
