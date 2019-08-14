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
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Promo_Widget_Chooser_Sku extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Construct Method
     * @param type $arguments
     */
    public function __construct($arguments = array()) {
        parent::__construct($arguments);

        if ($this->getRequest()->getParam('current_grid_id')) {
            $this->setId($this->getRequest()->getParam('current_grid_id'));
        } else {
            $this->setId('skuChooserGrid_' . $this->getId());
        }

        $form = $this->getJsFormObject();
        $this->setRowClickCallback("$form.chooserGridRowClick.bind($form)");
        $this->setCheckboxCheckCallback("$form.chooserGridCheckboxCheck.bind($form)");
        $this->setRowInitCallback("$form.chooserGridRowInit.bind($form)");
        $this->setDefaultSort('sku');
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('collapse')) {
            $this->setIsCollapsed(true);
        }
//        $this->setPagerVisibility(false);
//        $this->setFilterVisibility(false);
    }

    /**
     * Returns store object
     * @return type Store Object
     */
    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    /**
     * 
     * @param type $column
     * @return \Cybage_Megamenu_Block_Adminhtml_Megamenu_Promo_Widget_Chooser_Sku
     */
    protected function _addColumnFilterToCollection($column) {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $selected = $this->_getSelectedProducts();
            if (empty($selected)) {
                $selected = '';
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('sku', array('in' => $selected));
            } else {
                $this->getCollection()->addFieldToFilter('sku', array('nin' => $selected));
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare Catalog Product Collection for attribute SKU in Promo Conditions SKU chooser
     *
     * @return Mage_Adminhtml_Block_Promo_Widget_Chooser_Sku
     */
    protected function _prepareCollection() {
        $store = $this->_getStore();
        $collection = Mage::getResourceModel('catalog/product_collection')
                ->setStoreId(0)
                ->addAttributeToSelect('name', 'type_id', 'attribute_set_id');
        if ($store->getId()) {
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                    'name', 'catalog_product/name', 'entity_id', null, 'inner', $adminStore
            );
            $collection->joinAttribute(
                    'custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId()
            );
            $collection->joinAttribute(
                    'status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId()
            );
            $collection->joinAttribute(
                    'visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', $store->getId()
            );
            $collection->joinAttribute(
                    'price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId()
            );
        } else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Define Cooser Grid Columns and filters
     *
     * @return Mage_Adminhtml_Block_Promo_Widget_Chooser_Sku
     */
    protected function _prepareColumns() {

        $this->addColumn('in_products', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_products',
            'values' => $this->_getSelectedProducts(),
            'align' => 'center',
            'index' => 'sku',
            'use_index' => true,
        ));

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('sales')->__('ID'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'entity_id'
        ));

        $this->addColumn('type', array(
            'header' => Mage::helper('catalog')->__('Type'),
            'width' => '60px',
            'index' => 'type_id',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
                ->load()
                ->toOptionHash();

        $this->addColumn('set_name', array(
            'header' => Mage::helper('catalog')->__('Attrib. Set Name'),
            'width' => '100px',
            'index' => 'attribute_set_id',
            'type' => 'options',
            'options' => $sets,
        ));

        $this->addColumn('chooser_sku', array(
            'header' => Mage::helper('sales')->__('SKU'),
            'name' => 'chooser_sku',
            'width' => '80px',
            'index' => 'sku'
        ));
        $this->addColumn('chooser_name', array(
            'header' => Mage::helper('sales')->__('Product Name'),
            'name' => 'chooser_name',
            'index' => 'name'
        ));
        $this->addColumn('visibility', array(
            'header' => Mage::helper('catalog')->__('Visibility'),
            'width' => '70px',
            'index' => 'visibility',
            'type' => 'options',
            'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('catalog')->__('Status'),
            'width' => '70px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));


        //return $this;
    }

    /**
     * 
     * @return type String
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/chooser', array(
                    '_current' => true,
                    'current_grid_id' => $this->getId(),
                    'collapse' => null
        ));
    }

    /**
     * 
     * @return type Product Object
     */
    protected function _getSelectedProducts() {
        $products = $this->getRequest()->getPost('selected', array());

        return $products;
    }

}
