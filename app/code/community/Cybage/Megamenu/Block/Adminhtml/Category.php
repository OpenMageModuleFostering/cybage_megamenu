<?php

/**
 * return's the category tree html 
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Block_Adminhtml_Category {

    /**
     * Generate Categort list in Html
     * @param type $parentId
     * @param type $isChild
     * @return type
     */
    function getTreeCategories($parentId, $isChild) {
        $html = "";
        $allCats = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('is_active', '1')
                ->addAttributeToFilter('include_in_menu', '1')
                ->addAttributeToFilter('parent_id', array('eq' => $parentId))
                ->addAttributeToSort('position', 'asc');

        $class = ($isChild) ? "sub-cat-list" : "cat-list";
        $html .= '<ul class="' . $class . '">';
        foreach ($allCats as $category) {
            $html .= '<li><span>' . $category->getName() . "</span>";
            $subcats = $category->getChildren();
            if ($subcats != '') {
                $html .= $this->getTreeCategories($category->getId(), true);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return (string) $html;
    }

}
