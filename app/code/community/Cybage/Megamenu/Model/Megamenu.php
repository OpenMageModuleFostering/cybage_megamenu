<?php

/**
 * megamenu model 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Model_Megamenu extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('megamenu/megamenu');
    }

    /**
     * 
     * @param type $menuId
     * @param type $templateId
     * @param type $storeId
     * @return type collection object
     */
    public function getTemplateCollection($menuId, $templateId, $storeId) {
        $menuData = parent::load($menuId);
        $templateData = $menuData->getData();

        $attributeData = Mage::getModel('megamenu/attributes')->getValues($menuId, $templateData);

        Mage::log($attributeData, null, 'mega.log');

        //get category information
        if (!empty($attributeData['main_content_category_ids'])) {
            
            $attributeData['categories'] = $this->getCategoryDetails($attributeData['main_content_category_ids']);
        }

        //get featured category information
        if (!empty($attributeData['feature_category_ids'])) {
            $attributeData['feature_categories'] = $this->getFeatureCategories($attributeData['feature_category_ids']);
        }

        //get product information        
        if (!empty($attributeData['main_content_product_ids'])) {
            $attributeData['products'] = $this->getFeatureProducts($attributeData['main_content_product_ids']);
        }

        //get feature product information        
        if (!empty($attributeData['feature_product_ids'])) {
            $featureProdutsIds = $attributeData['feature_product_ids'];
            $featureproducts = explode(",", $featureProdutsIds);

            foreach ($featureproducts as $productSku) {
                $featureproduct = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($productSku));
                $path = Mage::getBaseUrl() . $featureproduct->getUrlPath();
                $name = $featureproduct->getName();
                $price = $featureproduct->getPrice();
                $image = Mage::helper('catalog/image')->init($featureproduct, 'image')->keepFrame(false)->resize(100, 100)->__toString();
                $featureprodDetailArray[] = array('name' => $name, 'path' => $path, 'price' => $price, 'image' => $image);
            }
            $attributeData['feature_products'] = $featureprodDetailArray;
        }
        return $attributeData;
    }

    /**
     * 
     * @param type $categoryIds
     * @return string
     */
    public function getCategoryDetails($categoryIds) {
        
        $mainCategoryIds = $categoryIds;
        $categories = explode(",", $mainCategoryIds);
        $categoryDetailArray = array();
        foreach ($categories as $catId) {
            
            $catetory = Mage::getModel('catalog/category')->load($catId);
            $path = Mage::getBaseUrl() . $catetory->getUrlPath();
//            print_r($catetory->getData());
            $name = $catetory->getName();
            if($catetory->getParentId()!=1 && $catetory->getIsActive()==1)
            $categoryDetailArray[] = array('name' => $name, 'path' => $path);
        }

        return $categoryDetailArray;
    }

    /**
     * 
     * @param type $categoryIds
     * @return type array
     */
    public function getFeatureCategories($categoryIds) {
        $featureCategoryIds = $categoryIds;
        $featurecategories = explode(",", $featureCategoryIds);
        $featurecategoryDetailArray = array();
        foreach ($featurecategories as $fcatId) {
            $featurecatetory = Mage::getModel('catalog/category')->load($fcatId);
            $name = $featurecatetory->getName();
            $url = $featurecatetory->getUrl();
            if($catetory->getParentId()!=1 && $catetory->getIsActive()==1)
            $featurecategoryDetailArray[] = array('name' => $name,'path'=>$url);
        }

        return $featurecategoryDetailArray;
    }
    
    /**
     * 
     * @param type $productIds
     * @return Array
     */
    public function getFeatureProducts($productIds) {
        $featureProdutsIds = $productIds;
        $featureproducts = explode(",", $featureProdutsIds);
        $featureprodDetailArray = array();
        foreach ($featureproducts as $productSku) {
            $featureproduct = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($productSku));
            $path = Mage::getBaseUrl() . $featureproduct->getUrlPath();
            $name = $featureproduct->getName();
            $price = $featureproduct->getPrice();
            $visiblity = $featureproduct->getVisibility();
            $status = $featureproduct->getStatus();
            $image = Mage::helper('catalog/image')->init($featureproduct, 'thumbnail')->keepFrame(false)->resize(120, 120)->__toString();
            //$this->helper('catalog/image')->init($featureproduct, 'thumbnail', $image->getFile())->resize(100,100);
            if($status==1 && $visiblity!=1){
                $featureprodDetailArray[] = array('name' => $name, 'path' => $path, 'price' => $price, 'image' => $image);
            }  
        }
        
        return $featureprodDetailArray;
    }

}
