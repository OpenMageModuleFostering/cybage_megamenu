<?php

/**
 * megamenu admin controller
 * @category Megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Promo'.DS.'WidgetController.php');
class Cybage_Megamenu_Adminhtml_WidgetController extends Mage_Adminhtml_Promo_WidgetController{
    //put your code here
    
    /**
     * Prepare block for chooser
     *
     * @return void
     */
    public function chooserAction()
    {
       
        $request = $this->getRequest();

        switch ($request->getParam('attribute')) {
            case 'sku':
                 
                $block = $this->getLayout()->createBlock(
                    'megamenu/adminhtml_megamenu_promo_widget_chooser_sku', 'promo_widget_chooser_sku',
                    array('js_form_object' => $request->getParam('form'),
                ));
                break;

            case 'category_ids':
                $ids = $request->getParam('selected', array());
                if (is_array($ids)) {
                    foreach ($ids as $key => &$id) {
                        $id = (int) $id;
                        if ($id <= 0) {
                            unset($ids[$key]);
                        }
                    }

                    $ids = array_unique($ids);
                } else {
                    $ids = array();
                }


                $block = $this->getLayout()->createBlock(
                        'adminhtml/catalog_category_checkboxes_tree', 'promo_widget_chooser_category_ids',
                        array('js_form_object' => $request->getParam('form'))
                    )
                    ->setCategoryIds($ids)
                ;
                break;

            default:
                $block = false;
                break;
        }

        if ($block) {
            $this->getResponse()->setBody($block->toHtml());
        }
    }
}
