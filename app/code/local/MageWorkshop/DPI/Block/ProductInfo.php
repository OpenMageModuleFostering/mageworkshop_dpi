<?php
class MageWorkshop_DPI_Block_ProductInfo extends Mage_Core_Block_Template
{

   // protected $_attributeSetSettings = array() ;

    public function getAttributesList($productId = false, $store = false)
    {
        if(!$productId) {
            $productId = $this->getRequest()->getParam('id');
        }
        $product = Mage::getModel('catalog/product')->load($productId);
        $data = array();
        if ($product->getId()) {
            $attributeSetId = $product->getAttributeSetId();
//            if(array_key_exists($attributeSetId, $this->_attributeSetSettings)) {
//                return $this->_attributeSetSettings[$attributeSetId];
//            }
            $checkedAttributes = $this->getCheckedAttributes($attributeSetId, $store);
            foreach ($product->getAttributes() as $attribute){
                if (in_array($attribute->getAttributeId(), $checkedAttributes) && $html = $this->getAttributeHtml($product, $attribute)) {
                    $data[$attribute->getStoreLabel()] = $html;
                }
            }
          //  $this->_attributeSetSettings[$attributeSetId] = $data;
        }
        return $data;
   }

    public function getCheckedAttributes($attributeSetId, $store = false)
    {
        $collection = Mage::getModel('dpi/attributeList')->getCollection();

        $collection->addFieldToFilter('store_id',$store? $store: Mage::app()->getStore()->getId())
            ->addFieldToFilter('attribute_set_id', $attributeSetId);
        if (!$collection->getSize()) {
            $collection->reset()
                ->addFieldToFilter('store_id', 0)
                ->addFieldToFilter('attribute_set_id', $attributeSetId);
        }
        $ids = array();
        foreach ($collection as $attribute) {
            $ids[] = $attribute->getAttributeId();
        }
        return $ids;
    }

    public function getAttributeHtml($product, $attribute)
    {
        $attrValue = $attribute->getFrontend()->getValue($product);
        if($attribute->getFrontendInput() != 'media_image') {
            if ($attribute->getFrontendInput() == 'price') {
                $attributeHtml = Mage::helper('core')->currency($attrValue);
            } elseif ($attribute->getFrontendInput() == 'textarea') {
                $attributeHtml = $attrValue;
            } else {
                $attributeHtml = $this->escapeHtml($attrValue);
            }
        } else {
            $label = $product->getName();
            $attributeHtml =
                '<img id="image" src="'.Mage::helper('catalog/image')->init($product, $attribute->getAttributeCode())->resize(125).'" width="125" alt="'.strip_tags($label).'" title="'.strip_tags($label).'" />';
        }
        return $attributeHtml;
    }

}