<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    CREATE TABLE IF NOT EXISTS `{$installer->getTable('dpi/attributeList')}` (
        `list_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
        `attribute_id` smallint(5) unsigned NOT NULL,
        `attribute_set_id` smallint(5) unsigned NOT NULL,
        `store_id` smallint(5) unsigned NOT NULL,
        PRIMARY KEY (`list_id`),
        CONSTRAINT `FK_DPI_CORE_STORE` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `FK_DPI_EAV_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `FK_DPI_EAV_ATTRIBUTE_SET` FOREIGN KEY (`attribute_set_id`) REFERENCES `eav_attribute_set` (`attribute_set_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");
$installer->endSetup();