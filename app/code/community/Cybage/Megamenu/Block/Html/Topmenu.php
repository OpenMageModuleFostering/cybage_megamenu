<?php
/**
 * return's the menu items to display in front end and also return template layout based on template_id  
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
 
class Cybage_Megamenu_Block_Html_Topmenu extends Mage_Core_Block_Template {

    /**
     * return megamenu collection
     * @return type obhect
     */
    public function getMenus() {
       
        $currentStore = $this->getCurrentStore();
        
        $storeId = Mage::app()->getStore()->getId(); 
        
        $cache = Mage::getSingleton('core/cache');
        $key = 'homepage-mega-menu-' . $storeId;
        
        if(! $data = $cache->load($key)){               
            $menuCollection = Mage::getModel('megamenu/megamenu')->getCollection()
                ->addFieldToFilter('is_active', array('eq' => 1))
                ->join(array("stores" => 'megamenu/stores'), 
                        "main_table.entity_id = stores.menu_id and store_id in (0, $currentStore) ", array())
                    ->setOrder('menu_order','asc'); 
             
            $data = serialize($menuCollection->getData());            
            $cache->save(urlencode($data), $key, array("homepage_cache"), 60*60*24);                
        }
        else{
             $data = urldecode($data); 
        } 
        
        $this->setConfigAttribute();        
        return unserialize($data);
    }

    /**
     * return template layout based on template_id
     * @param type $menuId
     * @param type $templateId
     * @return type layout object
     */
    public function generateMenu($menuId, $templateId) {
        $this->clearMenuRegister();
        $this->setMenuId($menuId);
        $this->setTemplateId($templateId);
        
        switch ($templateId) {
            case '1':
                return $this->getLayout()->createBlock('megamenu/html_topmenu')->setTemplate('megamenu/topmenu/categories.phtml')->toHtml();
                break;
            case '2':
                return $this->getLayout()->createBlock('megamenu/html_topmenu')->setTemplate('megamenu/topmenu/productsListing.phtml')->toHtml();
                break;
            case '3':
                return $this->getLayout()->createBlock('megamenu/html_topmenu')->setTemplate('megamenu/topmenu/groupMenuItems.phtml')->toHtml();
                break;
            case '4':
                return $this->getLayout()->createBlock('megamenu/html_topmenu')->setTemplate('megamenu/topmenu/contactus.phtml')->toHtml();
                break;
            case '5':
                return $this->getLayout()->createBlock('megamenu/html_topmenu')->setTemplate('megamenu/topmenu/anchorText.phtml')->toHtml();
                break;    
            case '6':
                return $this->getLayout()->createBlock('megamenu/html_topmenu')->setTemplate('megamenu/topmenu/contentText.phtml')->toHtml();
                break;
        }
        
    }

    /**
     * set menu_id in register
     * @param type $menuId
     */
    public function setMenuId($menuId) {
        Mage::register('menu_id', $menuId);
    }
    
    /**
     * set template_id in register
     * @param type $templateId
     */
    public function setTemplateId($templateId) {
        Mage::register('template_id', $templateId);
    }
    
    /**
     * return menu_id
     * @return type
     */
    public function getMenuId() {
        return Mage::registry('menu_id');
    }
    
    /**
     * return template_id
     * @return type int
     */
    public function getTemplateId() {
        return Mage::registry('template_id');
    }

    /**
     * clear registry
     */
    public function clearMenuRegister() {
        Mage::unregister('menu_id');
        Mage::unregister('template_id');
    }

    /**
     * return current store
     * @return type int
     */
    public function getCurrentStore() {
        return Mage::app()->getStore()->getStoreId();
    }
  
    /**
     * return template data 
     * @return type object
     */
    public function getTemplateData() {
        $menuId = $this->getMenuId();
        $templateId = $this->getTemplateId();
        $curremtStore = $this->getCurrentStore();
        $test = Mage::getModel('megamenu/megamenu')
                ->getTemplateCollection($menuId, $templateId, $curremtStore);
        return $test;
    }

    /**
     *  Seting Menu Background Color
     * Font Color
     * Font Size
     * Font Family
     * 
     */
    public function setConfigAttribute(){
        
        $backgroundColor = Mage::Helper('megamenu')->getBackgroundColor();
        $backgroundColor = !empty($backgroundColor)?
            'background:none repeat scroll 0 0'.$backgroundColor.'!important;':'';         
        
        Mage::unregister('backgroundColor');
        Mage::register('backgroundColor', $backgroundColor);
        
        $fontSize = Mage::Helper('megamenu')->getFontSize();
        $fontSize = (!empty($fontSize)||($fontSize >0))?
            'font-size:'.$fontSize.'px !important;':'';
        
        Mage::unregister('fontSize');
        Mage::register('fontSize', $fontSize);
        
        $fontFamily = Mage::Helper('megamenu')->getFontFamily();
        $fontFamily = !empty($fontFamily)?
            'font-family:'.$fontFamily.'!important;':'';
        
        Mage::unregister('fontFamily');
        Mage::register('fontFamily', $fontFamily);

        $fontColor =  Mage::Helper('megamenu')->getFontColor();
        $fontColor = !empty($fontColor)?
            'color:'.$fontColor.'!important;':'';
        
        Mage::unregister('fontColor');
        Mage::register('fontColor', $fontColor);
    }
}

