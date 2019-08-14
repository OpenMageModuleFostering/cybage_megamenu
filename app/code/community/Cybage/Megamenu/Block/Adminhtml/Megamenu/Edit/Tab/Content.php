<?php

/**
 * megamenu add/edit form content
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
class Cybage_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Prepare Layout
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    /**
     * Prepare From
     * @return type
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);


        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('tab_id' => 'form_section'));
        $wysiwygConfig["files_browser_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index');
        $wysiwygConfig["directives_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
        $wysiwygConfig["directives_url_quoted"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
        $wysiwygConfig["widget_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index');
        $wysiwygConfig["files_browser_window_width"] = (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width');
        $wysiwygConfig["files_browser_window_height"] = (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height');

        $plugins = $wysiwygConfig->getData("plugins");
        $plugins[0]["options"]["url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin');
        $plugins[0]["options"]["onclick"]["subject"] = "MagentovariablePlugin.loadChooser('" . Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin') . "', '{{html_id}}');";
        $plugins = $wysiwygConfig->setData("plugins", $plugins);


        $fieldset = $form->addFieldset('megamenu_form', array(
            'legend' => Mage::helper('megamenu')->__('Content Information')
        ));
        $menuList = Mage::getModel('megamenu/menutype')->getMenuList();

        $adminUrl = Mage::helper("adminhtml")
                ->getUrl("megamenu/adminhtml_megamenu/getTemplate");

        $fieldset->addField('type_id', 'select', array(
            'label' => Mage::helper('megamenu')->__('Menu type'),
            'name' => 'type_id',
            'onchange' => "getTemplates(this.value,'$adminUrl')",
            'class' => 'required-entry',
            'required' => true,
            'values' => $menuList,
            'data-adminurl' => $adminUrl
        ));

        $adminUrl = Mage::helper("adminhtml")
                ->getUrl("megamenu/adminhtml_megamenu/getLayoutImage");

        if ($this->getRequest()->getParam('id')) {

            $id = $this->getRequest()->getParam('id');
            $menuData = Mage::getModel('megamenu/megamenu')->load($id);
            $menuTypeId = $menuData->getTypeId();
            $templatesData = Mage::getModel('megamenu/menutemplate')->filterTtemplate($menuTypeId);
            $templateId = $menuData->getTemplateId();
            $mediaUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "megamenu" . DS;

            $templates = Mage::helper('megamenu')->toOptionsArray($templatesData);
            $fieldset->addField('template_id', 'select', array(
                'label' => Mage::helper('megamenu')->__('Template'),
                'name' => 'template_id',
                'class' => 'required-entry',
                'onchange' => "getLayoutImage(this.value,'$adminUrl')",
                'required' => true,
                'values' => $templates,
            ));
        } else {
            $fieldset->addField('admin_url', 'hidden', array(
                'name' => 'admin_url',
                    )
            );
            $fieldset->addField('template_id', 'select', array(
                'label' => Mage::helper('megamenu')->__('Template'),
                'name' => 'template_id',
                'class' => 'required-entry',
                'onchange' => "getLayoutImage(this.value,'$adminUrl')",
                'required' => true,
                'values' => array(
                    array(
                        'value' => '',
                        'label' => $this->__('Select Template Type'),
                    ),
                ),
            ));
        }


        if (Mage::getSingleton('adminhtml/session')->getMegamenuData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMegamenuData());
            Mage::getSingleton('adminhtml/session')->setMegamenuData(null);
        } elseif (Mage::registry('megamenu_data')) {
            $form->setValues(Mage::registry('megamenu_data')->getData());
        }
        $columnsize = Mage::helper('megamenu')->getMaximumColumnSize();
        $fieldset->addField('column_count', 'text', array(
            'label' => Mage::helper('megamenu')->__('Number of columns'),
            'class' => 'required-entry'
            . ' validate-digits-range digits-range-1-' . $columnsize,
            'required' => true,
            'name' => 'column_count',
            'after_element_html' => $this->__('<small>Please use numbers '
                    . 'only between 1-' . $columnsize . ' in this field</small>')
        ));
        $fieldset->addField('target_url', 'text', array(
            'label' => Mage::helper('megamenu')->__('Target Url'),
            'class' => 'validate-url validate-clean-url',
            'name' => 'target_url',
            'after_element_html' => '<small>Target Url</small>',
        ));
        $headerCotent = $form->addFieldset('megamenu_headercontent_form', array(
            'legend' => Mage::helper('megamenu')
                    ->__('Static Blocks')
                )
        );

        $blockcollection = Mage::getModel('cms/block')->getCollection()
                ->addFieldToFilter('identifier', array('like' => '%megamenu%'))
                ->addFieldToFilter('is_active', 1);

        $blocks[''] = $this->__('Please select a block');

        foreach ($blockcollection as $block) {

            $block_id = $block->getBlockId();
            $blocktitle = $block->getTitle();
            $blocks[] = array('value' => $block_id, 'label' => $blocktitle);
        }

        $headerCotent->addField('header', 'select', array(
            'label' => Mage::helper('megamenu')->__('Header Content'),
            'values' => $blocks,
            'name' => 'header',
        ));

        $headerCotent->addField('footer', 'select', array(
            'label' => Mage::helper('megamenu')->__('Footer Content'),
            'values' => $blocks,
            'name' => 'footer',
        ));

//feature products   
        $featureProduct = $form->addFieldset('megamenu_feature_form', array(
            'legend' => Mage::helper('megamenu')->__('Feature Product')
                )
        );

        $featureProduct->addField('feature_type', 'select', array(
            'label' => Mage::helper('megamenu')->__('Feature type'),
            'name' => 'feature_type',
            'onchange' => "toggleInputs(this.value)",
            'values' => array(
                array(
                    'value' => 20,
                    'label' => Mage::helper('megamenu')->__('None'),
                ),
                array(
                    'value' => 22,
                    'label' => Mage::helper('megamenu')->__('Product'),
                ),
            ),
        ));

        $featureProduct->addField('feature_category_box_title', 'text', array(
            'label' => Mage::helper('megamenu')->__('Feature Category box title'),
            'name' => 'feature_category_box_title',
        ));
        $featureProduct->addField('feature_product_box_title', 'text', array(
            'label' => Mage::helper('megamenu')->__('Feature Product box title'),
            'name' => 'feature_product_box_title',
        ));

        $ProductUrl = 'getFeatureProductChooser(\'' . Mage::getUrl(
                        'megamenu/adminhtml_widget/chooser/attribute/sku/form/feature_product_ids', array('_secure' => Mage::app()->getStore()->isAdminUrlSecure())
                ) . '?isAjax=true\'); return false;';
        $featureProduct->addField('feature_product_ids', 'text', array(
            'label' => Mage::helper('megamenu')->__('Feature Products'),
            'name' => 'feature_product_ids',
            'readonly' => 'readonly',
            'after_element_html' => '<br /><button type="button" class="product_button" onclick="' . $ProductUrl . '">Products</button>'
            . '<div id="featureproduct-chosser-container"></div>',
        ));


        

        //main content
        $mainCotent = $form->addFieldset('megamenu_maincontent_form', array('legend' => Mage::helper('megamenu')->__('Main Content')));


        $mainCotent->addField('category_box_title', 'text', array(
            'label' => Mage::helper('megamenu')->__('Categories box title'),
            'name' => 'category_box_title',
        ));

        $mainCotent->addField('prodct_box_title', 'text', array(
            'label' => Mage::helper('megamenu')->__('Product box title'),
            'name' => 'prodct_box_title',
        ));
        //category chooser          

        $categoryUrl = 'getMaincategoryChooser(\'' . Mage::getUrl(
                        'adminhtml/promo_widget/chooser/attribute/category_ids/form/main_content_category_ids', array('_secure' => Mage::app()->getStore()->isAdminUrlSecure())
                ) . '?isAjax=true\'); return false;';
        $mainCotent->addField('main_content_category_ids', 'text', array(
            'label' => Mage::helper('megamenu')->__('Categories'),
            'name' => 'main_content_category_ids',
            'readonly' => 'readonly',
            'after_element_html' => '<br /><button type="button" onclick="' . $categoryUrl . '">'
            . 'Categories</button><div id="main-chosser-container"></div>',
        ));



        $MainProductUrl = 'getMainProductChooser(\'' . Mage::getUrl(
                        'megamenu/adminhtml_widget/chooser/attribute/sku/form/main_content_product_ids', array('_secure' => Mage::app()->getStore()->isAdminUrlSecure())
                ) . '?isAjax=true\'); return false;';

        $mainCotent->addField('main_content_product_ids', 'text', array(
            'label' => Mage::helper('megamenu')->__('Products'),
            'name' => 'main_content_product_ids',
            'after_element_html' => '<br />'
            . '<button type="button" onclick="' . $MainProductUrl . '">Products</button>'
            . '<div id="mainproduct-chosser-container"></div>',
            'readonly' => 'readonly',
        ));



        $mainCotent->addField('content_container', 'editor', array(
            'name' => 'content_container',
            'label' => Mage::helper('megamenu')->__('Main Content'),
            'title' => Mage::helper('megamenu')->__('Main Content'),
            'style' => 'width:540px; height:300px;',
            'wysiwyg' => true,
            'required' => true,
            'config' => $wysiwygConfig,
        ));



        if (Mage::registry('megamenu_data')) {
            $getData = Mage::registry('megamenu_data')->getData();
            if ($this->getRequest()->getParam('id')) {
                $id = $this->getRequest()->getParam('id');
                $newData = Mage::getModel('megamenu/attributes')->getValues($id, $getData);
                $form->setValues($newData);
            }
        }
        return parent::_prepareForm();
    }

}
