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
class Cybage_Megamenu_Model_Adminhtml_Source_Contentsize {

    /**
     * Megamenu COnfig Column Size list
     * @return type array
     */
    public function toOptionArray() {
        return array_combine(range(100, 2048), range(100, 2048));
    }

}
