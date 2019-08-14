<?php
class DV_DPI_Model_Resource_AttributeList_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
      $this->_init('dpi/attributeList');
    }

    public function reset()
    {
        return $this->_reset();
    }
}
