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
