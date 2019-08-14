<?php
class DV_DPI_Model_Adminhtml_SaveConfig extends Mage_Core_Model_Config_Data
{
    public function _beforeSave()
    {
       if(!$this->getValue()) {
           Mage::getModel("core/config")->saveConfig('dpi/general/template_override', '0');
       }
    }
}