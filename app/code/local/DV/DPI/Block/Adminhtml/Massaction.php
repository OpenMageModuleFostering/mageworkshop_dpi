<?php
class DV_DPI_Block_Adminhtml_Massaction extends Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract
{

    public function __construct()
    {
        return $this->setTemplate('dpi/massaction.phtml');
    }

    public function isAvailable()
    {
        return true;
    }

    public function getJavaScript()
    {
        return false;
    }
}