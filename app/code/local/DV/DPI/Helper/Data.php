<?php
class DV_DPI_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'enabled';
    const XML_PATH_PRODUCT_PAGE = 'product_page';
    const XML_PATH_USE_MODAL = 'use_modal';
    const XML_PATH_USE_AJAX = 'use_ajax';

    public function getStoreConfig($config)
    {
        return Mage::getStoreConfig('dpi/general/' . $config);
    }
}