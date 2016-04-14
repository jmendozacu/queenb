<?php

class Linksync_Linksynceparcel_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$resource = Mage::getSingleton('core/resource');
	    $writeConnection = $resource->getConnection('core_write');
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_tabelrate');
		$query = "CREATE TABLE ".$table." (
			`pk` int(10) unsigned NOT NULL auto_increment,
			`website_id` int(11) NOT NULL default '0',
			`dest_country_id` varchar(4) NOT NULL default '0',
			`dest_region_id` varchar(255),
			`dest_zip` varchar(10) NOT NULL default '',
			`condition_name` varchar(20) NOT NULL default '',
			`condition_from_value` decimal(12,4) NOT NULL default '0.0000',
			`condition_to_value` decimal(12,4) NOT NULL default '0.0000',
			`price` decimal(12,4) NOT NULL default '0.0000',
			`price_per_kg` decimal(12,4) NOT NULL default '0.0000',
			`cost` decimal(12,4) NOT NULL default '0.0000',
			`delivery_type` varchar(50) NOT NULL default '',
			`charge_code` varchar(50) NULL default NULL,
			PRIMARY KEY  (`pk`),
			UNIQUE KEY `dest_country` ( `website_id` , `dest_country_id` , `dest_region_id` , `dest_zip` , `condition_name` , `condition_to_value` , `delivery_type`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_authority');
		$query = "CREATE TABLE ".$table." (
			`authority_id` int(10) unsigned NOT NULL auto_increment,
			`order_id` int(11) NOT NULL default '0',
			`instructions` text,
			PRIMARY KEY  (`authority_id`),
			UNIQUE KEY (`order_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_consignment');
		$query = "CREATE TABLE ".$table." (
			`order_id` int(11) NOT NULL default '0',
			`consignment_number` varchar(128) NOT NULL,
			`add_date` varchar(40) NOT NULL,
			`modify_date` varchar(40) NOT NULL,
			`delivery_signature_allowed` varchar(255),
			 `print_return_labels` varchar(255) NOT NULL,
		 	`contains_dangerous_goods` varchar(255) NOT NULL,
		 	`partial_delivery_allowed` varchar(255) NOT NULL,
			 `cash_to_collect` varchar(255) NOT NULL,
			 `despatched` tinyint(1) NOT NULL DEFAULT '0',
			 `label` varchar(255),
			 `manifest_number` varchar(255),
			 `is_next_manifest` tinyint(1) NOT NULL DEFAULT '0',
			 `is_label_printed` tinyint(1) NOT NULL DEFAULT '0', 
			 `is_label_created` tinyint(1) NOT NULL DEFAULT '0',
			 `email_notification` tinyint(1) DEFAULT '0',
			 `notify_customers` tinyint(1) DEFAULT '0',
			 `is_return_label_printed` tinyint(1) DEFAULT '0',
			 `general_linksynceparcel_shipping_chargecode` varchar(255),
			 weight varchar(20)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_article');
		$query = "CREATE TABLE ".$table." (
			`order_id` int(11) NOT NULL default '0',
			`consignment_number` varchar(255) NOT NULL,
			`article_number` varchar(255) NOT NULL,
			`actual_weight` varchar(255) NOT NULL,
			`article_description` varchar(255) NOT NULL,
			`cubic_weight` varchar(255) NOT NULL,
			`height` varchar(255) NOT NULL,
			`is_transit_cover_required` varchar(255) NOT NULL,
			`transit_cover_amount` varchar(255) NOT NULL,
			`length` varchar(40) NOT NULL,
			`width` varchar(255)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_manifest');
		$query = "CREATE TABLE ".$table." (
			`manifest_id` int(11) NOT NULL auto_increment primary key,																		
			`manifest_number` varchar(255) NOT NULL,
			`despatch_date` varchar(40) NOT NULL,
			`label` varchar(255) NOT NULL,
			`number_of_articles` int(11) NOT NULL,
			`number_of_consignments` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_free_shipping');
		$query = "CREATE TABLE ".$table." (
			`id` int(10) unsigned NOT NULL auto_increment,
			`charge_code` varchar(128) NOT NULL,
			`minimum_amount` decimal(12,4) NOT NULL,
			`status` tinyint(1) NOT NULL DEFAULT '1',
			`from_amount` decimal(12,2) DEFAULT '0',
			`to_amount` decimal(12,2) DEFAULT '0',
			PRIMARY KEY  (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_article_preset');
		$query = "CREATE TABLE ".$table." (
			`id` int(11) NOT NULL auto_increment,
			`name` varchar(255) NOT NULL,
			`weight` varchar(40) NOT NULL,
			`width` varchar(40) NOT NULL,
			`height` varchar(40) NOT NULL,
			`length` varchar(40) NOT NULL,
			`status` tinyint(1) NOT NULL DEFAULT '1',
			PRIMARY KEY  (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('sales_flat_order');
		$query = "ALTER TABLE  `".$table."` ADD is_address_valid TINYINT(1) DEFAULT 0";
		$writeConnection->query($query);*/
		
	   /* $table = $resource->getTableName('linksync_linksynceparcel_nonlinksync');
		$query = "CREATE TABLE IF NOT EXISTS ".$table." (
			`id` int(11) NOT NULL auto_increment,
			`method` varchar(255) NOT NULL,
			`charge_code` varchar(255) NOT NULL,
			PRIMARY KEY  (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
	    /*$table = $resource->getTableName('linksync_linksynceparcel_consignment');
		$query = "ALTER TABLE  `".$table."`  ADD INDEX `con_order_id_despatched` ( `order_id` , `despatched` )";
		$writeConnection->query($query);
		$query = "ALTER TABLE  `".$table."`  ADD INDEX `con_consignment_number` ( `consignment_number`)";
		$writeConnection->query($query);
		$query = "ALTER TABLE  `".$table."`  ADD INDEX `con_manifest_number` ( `manifest_number`)";
		$writeConnection->query($query);
		
		$table = $resource->getTableName('linksync_linksynceparcel_article');
		$query = "ALTER TABLE  `".$table."`  ADD INDEX `art_consignment_number` ( `consignment_number`)";
		$writeConnection->query($query);
		
		$table = $resource->getTableName('linksync_linksynceparcel_manifest');
		$query = "ALTER TABLE  `".$table."`  ADD INDEX `man_manifest_number` ( `manifest_number`)";
		$writeConnection->query($query);*/
		
		$isupgraded = Mage::helper('linksynceparcel')->isupgraded();
		
		if(!$isupgraded) {
			$table = $resource->getTableName('linksync_linksynceparcel_international_fields');
			$query = "CREATE TABLE IF NOT EXISTS `". $table ."` (
						`order_id` int(11) NOT NULL DEFAULT '0',
						`consignment_number` varchar(128) NOT NULL,
						`add_date` varchar(40) NOT NULL,
						`modify_date` varchar(40) NOT NULL,
						`insurance` tinyint(1) NOT NULL DEFAULT '0',
						`insurance_value` varchar(255) NOT NULL,
						`export_declaration_number` varchar(255) NOT NULL,
						`declared_value` tinyint(1) NOT NULL DEFAULT '0',
						`declared_value_text` varchar(255) NOT NULL,
						`has_commercial_value` tinyint(1) NOT NULL DEFAULT '0', 
						`product_classification` int(11) NOT NULL DEFAULT '991',
						`product_classification_text` varchar(255) NOT NULL,
						`country_origin` varchar(255) DEFAULT NULL,
						`hs_tariff` varchar(255) DEFAULT NULL,
						`default_contents` varchar(255) DEFAULT NULL,
						`ship_country` varchar(255) DEFAULT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			$writeConnection->query($query);
			
			$table = $resource->getTableName('linksync_linksynceparcel_consignment');
			$query = "ALTER TABLE `". $table ."` 
					ADD `delivery_country` varchar(10),
					ADD `customdocs` varchar(255),
					ADD `is_customdocs_printed` tinyint(1) NOT NULL DEFAULT '0' AFTER `is_label_printed`,
					ADD `delivery_instruction` varchar(300),
					ADD `safe_drop` tinyint(1);";
			$writeConnection->query($query);
		}
		
		echo 'Upgrade complete! Hit the back button to return to the previous screen.';
    }
	
	public function ExportTableRatesAction()
	{
		$extensionPath = Mage::helper('linksynceparcel')->getExtensionPath();
		$etcPath = $extensionPath.DS.'etc';
		$csvFilename = $etcPath.DS.'linksync_eparcel_tablerate.csv';
		if(!file_exists($csvFilename))
		{
			$csvFilename = $etcPath.DS.'linksync_eparcel_tablerate_default.csv';
		}
		
		$filename = 'linksync_eparcel_tablerate.csv';
		$content = array(
			'type'  => 'filename',
			'value' => $csvFilename,
			'rm'    => false 
		);

        $this->_prepareDownloadResponse($filename, $content);
	}
	
	public function updateLabelAsPrintedAction()
	{
		$consignmentNumber = $this->getRequest()->getParam('consignmentNumber');
		$consignmentNumber = preg_replace('/[^0-9a-zA-Z]/', '', $consignmentNumber);
		$pos = strpos($consignmentNumber, 'int');
		if ($pos === false) {			
			Mage::helper('linksynceparcel')->updateConsignmentTable2($consignmentNumber,'is_label_printed', 1);
		} else {
			$consignmentNumber = str_replace('int', '', $consignmentNumber);
			Mage::helper('linksynceparcel')->updateConsignmentTable2($consignmentNumber,'is_customdocs_printed', 1);
		}
	}
	
	public function updateReturnLabelAsPrintedAction()
	{
		$consignmentNumber = $this->getRequest()->getParam('consignmentNumber');
		$consignmentNumber = preg_replace('/[^0-9a-zA-Z]/', '', $consignmentNumber);
		Mage::helper('linksynceparcel')->updateConsignmentTable2($consignmentNumber,'is_return_label_printed', 1);
	}
	
	public function sendlogAction()
	{
		try
		{
			if(!Mage::helper('linksynceparcel')->isZipArchiveInstalled())
			{
				throw new Exception('PHP ZipArchive extension is not enabled on your server, contact your web hoster to enable this extension.');
			}
			else
			{
				if(Mage::getModel('linksynceparcel/api')->sendLog())
				{
					$message =  'Log has been sent to LWS successfully.';
				}
				else
				{
					$message =  'Log failed to sent to LWS';
				}
				Mage::log('Send Log: '.$message, null, 'linksync_eparcel.log', true);
				echo $message;
			}
		}
		catch(Exception $e)
		{
			$message = $e->getMessage();
			Mage::log('Send Log: '.$message, null, 'linksync_eparcel.log', true);
			echo $message;
		}
	}
}