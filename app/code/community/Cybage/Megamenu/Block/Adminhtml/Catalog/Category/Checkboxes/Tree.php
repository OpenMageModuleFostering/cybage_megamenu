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

class Cybage_Megamenu_Block_Adminhtml_Catalog_Category_Checkboxes_Tree extends Mage_Adminhtml_Block_Catalog_Category_Tree {

    protected function _prepareLayout() {
        $this->setTemplate('megamenu/catalog/category/checkboxes/tree.phtml');
    }

}
