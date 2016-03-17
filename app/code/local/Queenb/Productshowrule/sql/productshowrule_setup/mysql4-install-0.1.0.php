<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('productshowrule')};
CREATE TABLE {$this->getTable('productshowrule')} (
  `productshowrule_id` int(11) unsigned NOT NULL auto_increment,
  `cusgroupid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`productshowrule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 