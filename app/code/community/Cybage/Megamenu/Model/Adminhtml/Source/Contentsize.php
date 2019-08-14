<?php

/**
 * megamenu Adminhtml Source Contentsize return  Adminhtml Source Contentsize
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  11-May-2015 04:28 PM [IST]
 * @modified_at 11-May-2015 04:40 PM [IST]   
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
