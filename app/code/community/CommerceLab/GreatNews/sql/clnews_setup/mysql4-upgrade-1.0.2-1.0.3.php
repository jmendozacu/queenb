<?php

$installer = $this;
/** @var $installer Enterprise_CatalogEvent_Model_Resource_Setup */

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('clnews/news')} ADD `meta_title` varchar(255) NOT NULL DEFAULT '' AFTER author;");
$installer->endSetup();
