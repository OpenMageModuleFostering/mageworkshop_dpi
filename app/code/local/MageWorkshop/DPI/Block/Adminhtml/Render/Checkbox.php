<?php
class MageWorkshop_DPI_Block_Adminhtml_Render_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $checked = $row->getData('attr_enabled') ? ' checked="checked"' : '';
        $html = sprintf('<input type="checkbox" name="%s" value="%s" %s%s />',
            $this->getColumn()->getFieldName(),
            $this->escapeHtml($row->getId()),
            $this->getColumn()->getInlineCss(),
            $checked
        );
        return $html;
    }
}