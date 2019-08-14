<?php
class DV_DPI_Block_Adminhtml_AttributeSets extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'dpi';
        $this->_controller = 'adminhtml_attributeSets';
        $this->_headerText = $this->__('DPI Attribute Sets');
        parent::__construct();
        $this->_removeButton('add');
    }
}