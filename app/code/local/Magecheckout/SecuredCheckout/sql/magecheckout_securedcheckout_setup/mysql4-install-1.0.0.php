<?php
$installer = $this;
$installer->startSetup();
$installer->run("

    DROP TABLE IF EXISTS {$this->getTable('securedcheckout/survey')};
		CREATE TABLE {$this->getTable('securedcheckout/survey')}(
			`survey_id` int(11) unsigned NOT NULL auto_increment,
			`question` varchar(255) default '',
			`answer` varchar(255) default '',
		    `order_id` int(10) unsigned NOT NULL,
		    PRIMARY KEY (`survey_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

     DROP TABLE IF EXISTS {$this->getTable('securedcheckout/delivery')};
       CREATE TABLE {$this->getTable('securedcheckout/delivery')} (
            `delivery_id` int(11) unsigned NOT NULL auto_increment,
            `delivery_time_date` varchar(16) default '',
            `order_id` int(11) NOT NULL default '0',
            PRIMARY KEY (`delivery_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
       

       DROP TABLE IF EXISTS {$this->getTable('securedcheckout/attribute')};
       CREATE TABLE {$this->getTable('securedcheckout/attribute')} (
            `attribute_id` smallint(5) unsigned NOT NULL default 0,
            `attribute_code` varchar(255) default NULL,
            `entity_type_id` smallint(5) default 0,
            `is_billing` smallint(1) default 0,
            `is_used_for_secured_checkout` varchar(10),
            `position` smallint(5),
            `colspan` smallint(1),
            PRIMARY KEY (`attribute_id`),
            FOREIGN KEY (`attribute_id`) REFERENCES {$this->getTable('eav/attribute')} (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        

        DROP TABLE IF EXISTS {$this->getTable('securedcheckout/customblock_shoppingcart')};
        CREATE TABLE `{$this->getTable('securedcheckout/customblock_shoppingcart')}` (
          `rule_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL DEFAULT '',
          `description` text NOT NULL,
          `is_active` tinyint(1) NOT NULL,
          `website_ids` varchar(255) NOT NULL,
          `static_blocks_ids` text,
          `customer_group_ids` varchar(255) DEFAULT NULL,
          `from_date` date DEFAULT NULL,
          `to_date` date DEFAULT NULL,
          `sort_order` int(11) unsigned DEFAULT NULL,
          `conditions_serialized` mediumtext,
          `stop_rules` tinyint(1) DEFAULT NULL,
          `is_securedcheckout` tinyint(1) DEFAULT '0',
          `is_checkout_success` tinyint(1) DEFAULT '0',
          PRIMARY KEY (`rule_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

	");
/*Abandoned Cart*/
$configTableName = $this->getTable('securedcheckout/abandonedcart_customer');
$installer->run("
    DROP TABLE IF EXISTS $configTableName;
    CREATE TABLE $configTableName (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `quote_id` int(10) unsigned NOT NULL,
      `email` varchar(255) NOT NULL,
      `is_sent` smallint(1) NOT NULL default 0,
      FOREIGN KEY (`quote_id`) REFERENCES {$this->getTable('sales/quote')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
/*\Abandoned Cart*/
try {
    /*Add giftwrap to sales_order table*/
    $installer->getConnection()->addColumn($this->getTable('sales/order'), 'mc_giftwrap_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/order'), 'mc_giftwrap_base_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/order_item'), 'mc_giftwrap_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/order_item'), 'mc_giftwrap_base_amount', 'decimal(12,4) NOT NULL default 0');
    /*Add giftwrap to sales_order_invoice tabel*/
    $installer->getConnection()->addColumn($this->getTable('sales/invoice'), 'mc_giftwrap_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/invoice'), 'mc_giftwrap_base_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/invoice_item'), 'mc_giftwrap_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/invoice_item'), 'mc_giftwrap_base_amount', 'decimal(12,4) NOT NULL default 0');
    /*Add giftwrap to sales_order_creditmemo tabel*/
    $installer->getConnection()->addColumn($this->getTable('sales/creditmemo'), 'mc_giftwrap_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/creditmemo'), 'mc_giftwrap_base_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/creditmemo_item'), 'mc_giftwrap_amount', 'decimal(12,4) NOT NULL default 0');
    $installer->getConnection()->addColumn($this->getTable('sales/creditmemo_item'), 'mc_giftwrap_base_amount', 'decimal(12,4) NOT NULL default 0');
} catch (Exception $e) {
}

/*Add customer attribute fields*/
$this->addCustomerFieldToSecuredCheckout($installer);

/*Insert Magecheckout OSC Static Blocks*/
$this->insertStaticBlocks();
/*Insert Fields*/
$this->insertFieldsPosition();

$installer->endSetup();