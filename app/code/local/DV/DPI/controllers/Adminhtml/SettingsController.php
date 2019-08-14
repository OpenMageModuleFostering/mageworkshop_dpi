<?php
class DV_DPI_Adminhtml_SettingsController extends Mage_Adminhtml_Controller_Action
{
    protected $_activeMenu = false;

    public function indexAction()
    {
        $this->_title($this->__('Attribute Sets List'));
        $this->_activeMenu = 'catalog';
    }

    public function loadAttributeSetGridAction() {}

    public function containerAction() {}

    public function loadAttributeAction()
    {
        $this->_title($this->__('Attributes List'));
        $this->_activeMenu = 'catalog';
    }

    public function loadAttributeGridAction() {}

    public function saveSettingsAction()
    {
        $session = Mage::getSingleton('adminhtml/session');
        $attributeSetId = $this->getRequest()->getParam('id');
        $storeId =  $this->getRequest()->getParam('store')? $this->getRequest()->getParam('store') : 0;

        $checked = $this->getRequest()->getParam('checked')? explode(',', $this->getRequest()->getParam('checked')) : array();
        $unchecked = $this->getRequest()->getParam('unchecked')? explode(',', $this->getRequest()->getParam('unchecked')) : array();

        //get object for delete
        $modelAttrList = Mage::getModel('dpi/attributeList');
        $attrDeleteCollection = $modelAttrList->getCollection();
        $attrDeleteCollection
            ->addFieldToFilter('attribute_id',     array('in' => array_merge($checked, $unchecked)))
            ->addFieldToFilter('store_id',         array('eq' => $storeId))
            ->addFieldToFilter('attribute_set_id', array('eq' => $attributeSetId));
        try
        {
            foreach ($attrDeleteCollection as $object) {
                $object->delete();
            }

             //insert
            $model = Mage::getModel('dpi/attributeList');
            foreach ($checked as $attributeId) {
                $model->setData(array(
                    'attribute_id'      => $attributeId,
                    'store_id'          => $storeId,
                    'attribute_set_id'  => $attributeSetId
                ));
                $model->save();
            }
            $session->addSuccess(Mage::helper('dpi')->__('The attribute settings has been saved.'));
        } catch (Exception $e) {
            $session->addError($e->getMessage());
        }
    }

    public function postDispatch()
    {
        $this->loadLayout();
        if($this->_activeMenu) {
            $this->_setActiveMenu($this->_activeMenu);
        }
        $this->renderLayout();
        parent::postDispatch();
    }

}