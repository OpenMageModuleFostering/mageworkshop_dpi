<?php
class DV_DPI_Block_Adminhtml_Attributes extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'dpi';
        $this->_controller = 'adminhtml_attributes';
        $this->_headerText = $this->__('DPI Attributes');
        parent::__construct();
        $this->_removeButton('add');
    }
}