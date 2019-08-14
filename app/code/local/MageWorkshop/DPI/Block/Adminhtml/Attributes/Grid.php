<?php
class MageWorkshop_DPI_Block_Adminhtml_Attributes_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('attributesGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setDefaultSort('frontend_label');
        $this->setDefaultDir('asc');
    }

    protected function _prepareCollection()
    {
        $attributeSetId = $this->getRequest()->getParam('id');
        $storeId = $this->getRequest()->getParam('store') ?  $this->getRequest()->getParam('store') : 0;

        $additionalJs = "
                var jsObject = {$this->getJsObjectName()};
                if(jsObject.reloadParams){
                   jsObject.reloadParams.id = {$attributeSetId};
                } else
                {
                    jsObject.reloadParams = {id: {$attributeSetId}};
                }
            ";
        $this->setAdditionalJavaScript($additionalJs);

        $collection = Mage::getModel('eav/entity_attribute')->getCollection();
        $collection->setAttributeSetFilter(array($attributeSetId));
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);

        $collection->getSelect()
            ->joinLeft(array('dal' => $collection->getTable('dpi/attributeList')),
                "main_table.attribute_id=dal.attribute_id AND dal.store_id=$storeId AND dal.attribute_set_id=$attributeSetId",
                array('IFNULL(dal.attribute_id, 0) as attr_enabled'))
            ->where('main_table.frontend_label IS NOT NULL AND main_table.frontend_label!=""');


        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('chk_attribute', array(
            'header'        => Mage::helper('dpi')->__('Yes/No'),
            'align'         => 'center',
            'filter'        => false,
            'width'         => '30px',
            'index'         => 'attr_enabled',
            'inline_css'    => 'class="selected-values"',
            'renderer'      => 'dpi/adminhtml_render_checkbox'
        ));

        $this->addColumn('attribute_id', array(
            'header'        => Mage::helper('dpi')->__('ID'),
            'type'          =>'number',
            'align'         => 'center',
            'filter_index'  => 'main_table.attribute_id',
            'index'         => 'attribute_id'
        ));

        $this->addColumn('frontend_label', array(
            'header'        => Mage::helper('dpi')->__('Attribute'),
            'align'         => 'left',
            'sortable'      => true,
            'filter_index'  => 'frontend_label',
            'index'         => 'frontend_label'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassactionBlock()
    {
        $this->setChild('massaction', $this->getLayout()->createBlock('dpi/adminhtml_massaction'));
        return $this;
    }


    protected function _prepareLayout()
    {
        $url = (string) $this->getUrl('dpi/settings/saveSettings', array('_current'=>true));
        $onClick = "
            if(!confirm('{$this->__('Save attributes settings?')}')){
                return;
            }
            var chk = [];
            var unchk = [];
            $$('.selected-values').each(function(item) {
                if (item.checked){
                   chk.push(item.value);
                } else
                {
                   unchk.push(item.value);
                }
            });
            var jsObject = {$this->getJsObjectName()};
            if(chk.length || unchk.length) {
                if(jsObject.reloadParams) {
                    jsObject.reloadParams.checked = chk.join();
                    jsObject.reloadParams.unchecked = unchk.join();
                } else {
                    jsObject.reloadParams = { checked: chk.join(), unchecked: unchk.join() };
                }
            }
            jsObject.reload('{$url}');
        ";

        $this->setChild('submit_button',
        $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label'     => Mage::helper('adminhtml')->__('Save Changes'),
                'onclick'   => $onClick,
                'class'     => 'task'
            ))
        );

        return parent::_prepareLayout();
    }

    public function getSubmitButtonHtml()
    {
        return $this->getChildHtml('submit_button');
    }

    public function getMainButtonsHtml()
    {
        $html = parent::getMainButtonsHtml();
        $html .= $this->getSubmitButtonHtml();
        return $html;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/loadAttributeGrid', array('_current'=>true));
    }

    protected function _toHtml()
    {
        return parent::_toHtml() . $this->getChildHtml('additional_js');
    }

}