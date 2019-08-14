<?php

/**
 * megamenu Adminhtml Source Fontsize return  Adminhtml Source Fontsize
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  11-May-2015 04:28 PM [IST]
 * @modified_at 11-May-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Model_Adminhtml_Source_Fontsize {

    /**
     * Megamenu COnfig Font Size list
     * @return type array
     */
    public function toOptionArray() {
        return range(0, 72);
    }

}
