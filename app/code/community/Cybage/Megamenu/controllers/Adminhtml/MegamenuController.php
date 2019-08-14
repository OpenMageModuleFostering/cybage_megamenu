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
class Cybage_Megamenu_Adminhtml_MegamenuController extends Mage_Adminhtml_Controller_Action {

    /**
     * Initializing menamenu in admin 
     * @return \Cybage_Megamenu_Adminhtml_MegamenuController
     */
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('megamenu/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')
                        ->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    /**
     * Inde Action
     * Display Grid Page
     */
    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * Edit Action
     */
    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('megamenu/megamenu')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('megamenu_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('megamenu/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('megamenu/adminhtml_megamenu_edit'))
                    ->_addLeft($this->getLayout()->createBlock('megamenu/adminhtml_megamenu_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('megamenu')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Add new Menu action
     */
    public function newAction() {
        $this->_forward('edit');
    }

    /**
     * Save Menu
     */
    public function saveAction() {

        if ($data = $this->getRequest()->getPost()) {
            if (!empty($data['type_id']) &&
                    intval($data['type_id']) &&
                    !empty($data['template_id']) &&
                    intval($data['template_id'])
            ) {

                if ($this->getRequest()->getParam('id')) {
                    $id = $this->getRequest()->getParam('id');
                    $model = Mage::getModel('megamenu/megamenu');
                    try {
                        $model->setData(array(
                            'entity_id' => $id,
                            'name' => $data['name'],
                            'titel' => $data['titel'],
                            'type_id' => $data['type_id'],
                            'template_id' => $data['template_id'],
                            'menu_order' => $data['order'],
                            'is_active' => $data['is_active'],
                            'header' => $data['header'],
                            'footer' => $data['footer'],
                            'update_time' => now(),
                        ));
                        $model->save();
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('megamenu')
                                        ->__('The menu has been saved.'));
                        if ($this->getRequest()->getParam('back') == 'edit') {
                            $this->_redirect('*/*/edit', array('id' => Mage::app()->getRequest()->getParam('id')));
                        } else {
                            $this->_redirect('*/*/');
                        }
                    } catch (Exception $e) {
                        $this->_redirect('*/*/edit', array('id' => Mage::app()->getRequest()->getParam('id')));

                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('megamenu')
                                        ->__('Duplicate entry for order'));
                        Mage::getSingleton('adminhtml/session')->setFormData($data);
                    }

                    //save stores for menu
                    Mage::getModel('megamenu/stores')->updateStores($id, $data);

                    // process post data and save attribute values
                    Mage::getModel('megamenu/menuattributevalues')->processData($id, $data);
                } else {

                    // save megamenu comman data
                    $model = Mage::getModel('megamenu/megamenu');
                    $model->setData(array(
                        'type_id' => $data['type_id'],
                        'template_id' => $data['template_id'],
                        'name' => $data['name'],
                        'titel' => $data['titel'],
                        'is_active' => $data['is_active'],
                        'menu_order' => $data['order'],
                        'header' => $data['header'],
                        'footer' => $data['footer'],
                    ))->setId($this->getRequest()->getParam('id'));


                    try {
                        if ($model->getCreatedTime == NULL ||
                                $model->getUpdateTime() == NULL) {
                            $model->setCreatedTime(now())
                                    ->setUpdateTime(now());
                        } else {
                            $model->setUpdateTime(now());
                        }
                        $model->save();
                        $menuId = $model->getId();

                        //save stores for menu
                        Mage::getModel('megamenu/stores')->updateStores($menuId, $data);

                        // process post data and save attribute values
                        Mage::getModel('megamenu/menuattributevalues')->processData($menuId, $data);

                        Mage::getSingleton('adminhtml/session')
                                ->addSuccess(Mage::helper('megamenu')
                                        ->__('The menu has been saved.'));
                        Mage::getSingleton('adminhtml/session')->setFormData(false);
                        if ($this->getRequest()->getParam('back')) {
                            $this->_redirect('*/*/edit', array('id' => $menuId));
                        } else {
                            $this->_redirect('*/*/');
                        }
                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError('Duplicate entry for order');
                        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    }
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError('Invalid Data type');
            }
        } else {
            $this->_redirect('*/*/');
        }
    }

    /**
     * Delete Menu
     */
    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('megamenu/megamenu');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Mass Delete Action
     */
    public function massDeleteAction() {
        $megamenuIds = $this->getRequest()->getParam('megamenu');
        if (!is_array($megamenuIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                $megamenu = Mage::getModel('megamenu/megamenu')
                        ->getCollection()
                        ->addFieldToFilter('entity_id', array('in' => $megamenuIds));

                foreach ($megamenu as $megamenuId) {
                    $megamenuId->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($megamenuIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Mass Status Change Action
     */
    public function massStatusAction() {
        $megamenuIds = $this->getRequest()->getParam('megamenu');
        if (!is_array($megamenuIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($megamenuIds as $megamenuId) {
                    $megamenu = Mage::getSingleton('megamenu/megamenu')
                            ->load($megamenuId)
                            ->setIs_active($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($megamenuIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Get Template Action
     */
    public function getTemplateAction() {

        $postData = $this->getRequest()->getPost();
        $menuTypeId = $postData['type_id'];
        $templates = Mage::getModel('megamenu/menutemplate')->filterTtemplate($menuTypeId);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($templates));
    }

    /**
     * Get Layout Image Action
     */
    public function getLayoutImageAction() {
        $postData = $this->getRequest()->getPost();
        $layoutId = $postData['template_id'];
        $mediaUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageName = $mediaUrl . 'megamenu/' . Mage::getModel('megamenu/menutemplate')->load($layoutId)->getLayoutImage();
        $this->getResponse()->setBody($imageName);
    }

    /**
     * Get Categories Action
     */
    public function getCategoriesAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Clear Menu Cache Action
     */
    public function clearCacheAction() {
        $storeId = Mage::app()->getStore()->getId();
        $cache = Mage::getSingleton('core/cache');
        $key = 'homepage-mega-menu-' . $storeId;

        $data = $cache->clean('homepage_cache');
        if ($data) {
            Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('adminhtml')->__('Menu cache cleared successfully'));
        }
        $this->_redirect('*/*/index');
    }

}
