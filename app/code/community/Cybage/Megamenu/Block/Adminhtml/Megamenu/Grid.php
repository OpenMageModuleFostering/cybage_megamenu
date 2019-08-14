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
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('megamenuGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare Collection
     * @return type object
     */
    protected function _prepareCollection() {

        $collection = Mage::getModel('megamenu/megamenu')->getCollection();
        $collection->getSelect()
                ->join(Mage::getConfig()
                        ->getTablePrefix() . 'megamenu_type', 'main_table.type_id =' . Mage::getConfig()
                        ->getTablePrefix() . 'megamenu_type.entity_id', array('type'));

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare column
     * @return type object
     */
    protected function _prepareColumns() {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('megamenu')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('megamenu')->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        $this->addColumn('menu_order', array(
            'header' => Mage::helper('megamenu')->__('Order'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'menu_order',
        ));
        $this->addColumn('type', array(
            'header' => Mage::helper('megamenu')->__('Menu Type'),
            'align' => 'left',
            'index' => 'type',
        ));


        $this->addColumn('is_active', array(
            'header' => Mage::helper('megamenu')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('megamenu')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('megamenu')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('megamenu')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('megamenu')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * 
     * @return \Cybage_Megamenu_Block_Adminhtml_Megamenu_Grid
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('megamenu');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('megamenu')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('megamenu')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('megamenu/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('megamenu')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('megamenu')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    /**
     * Get Row URL
     * @param type $row
     * @return type STRING
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
