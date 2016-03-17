<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('qtymgnt')};
CREATE TABLE IF NOT EXISTS {$this->getTable('qtymgnt')} (
  `qtymgnt_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `customergroup` int(11) NOT NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`qtymgnt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS {$this->getTable('qtymgntdetails')} (
  `qtymgntdetails_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `qtymgnt_id` int(11) NOT NULL,
  `customergroup` int(11) NOT NULL,
  `qtyvalue` text NOT NULL,
  `productid` int(11) NOT NULL,
  PRIMARY KEY (`qtymgntdetails_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 