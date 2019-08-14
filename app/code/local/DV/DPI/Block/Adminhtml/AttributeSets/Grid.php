<?php
class DV_DPI_Block_Adminhtml_AttributeSets_Grid  extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        $this->setId('attributeSetsGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    public function _prepareCollection()
    {
        $model = Mage::getModel('eav/entity_type');
        $model->getResource()
              ->loadByCode($model, Mage_Catalog_Model_Product::ENTITY);

        $collection = Mage::getModel('eav/entity_attribute_set')->getCollection();
        $collection->setEntityTypeFilter($model->getId());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function _prepareColumns()
    {
        $this->addColumn('attribute_set_id', array(
            'header'        => Mage::helper('dpi')->__('ID'),
            'type'          => 'number',
            'align'         => 'left',
            'filter_index'  => 'attribute_set_id',
            'index'         => 'attribute_set_id'
        ));

        $this->addColumn('attribute_set_name', array(
            'header'        => Mage::helper('dpi')->__('Attribute set'),
            'align'         => 'left',
            'filter_index'  => 'attribute_set_name',
            'index'         => 'attribute_set_name'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($attributeSet)
    {
        //return $this->getUrl('*/*/loadAttribute', array(
        return $this->getUrl('*/*/loadAttribute', array(
            'id' => $attributeSet->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/loadAttributeSetGrid', array('_current'=>true));
    }

}