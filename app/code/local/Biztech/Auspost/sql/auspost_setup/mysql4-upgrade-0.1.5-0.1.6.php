<?php
    $installer = $this;

    $installer->startSetup();
    
    $code = 'auspost_package_type';
    $package_type = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product',$code);
    if(null===$package_type->getId()) {
    $installer->addAttribute('catalog_product', 'auspost_package_type', array(
            'label'         => 'Australia Post Package Type',
            'group'         => 'General',
            'input'         => 'select',
            'type'          => 'int',
            'visible'       => 1,
            'required'      => 0,
            'user_defined'  => 1,
            'source'        => 'eav/entity_attribute_source_table',
            'backend'    => 'eav/entity_attribute_backend_array',
            'option'     => array (
                'values' => array(
                    0 => 'Parcel',
                    1 => 'Letter'

                )),
            'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL

        ));
    }
    
    /* Create a database table for eParcel table rates.*/
    $installer->run("
    DROP TABLE IF EXISTS {$this->getTable('auspost_eparcel')};
    CREATE TABLE {$this->getTable('auspost_eparcel')} (
      `pk` int(10) unsigned NOT NULL auto_increment,
      `website_id` int(11) NOT NULL default '0',
      `dest_country_id` varchar(4) NOT NULL default '0',
      `dest_region_id` int(10) NOT NULL default '0',
      `dest_zip` varchar(10) NOT NULL default '',
      `condition_name` varchar(20) NOT NULL default '',
      `condition_from_value` decimal(12,4) NOT NULL default '0.0000',
      `condition_to_value` decimal(12,4) NOT NULL default '0.0000',
      `price` decimal(12,4) NOT NULL default '0.0000',
      `price_per_kg` decimal(12,4) NOT NULL default '0.0000',
      `cost` decimal(12,4) NOT NULL default '0.0000',
      `delivery_type` varchar(50) NOT NULL default '',
      `dest_zip_range` varchar(255) NULL default '',
      `charge_code_individual` varchar(50) NULL default NULL,
      `charge_code_business` varchar(50) NULL default NULL,
      `stock_id` int NULL DEFAULT '0' COMMENT 'Warehouse ID for Multi Warehouse extension',
      PRIMARY KEY  (`pk`),
      UNIQUE KEY `dest_country` ( `website_id` , `dest_country_id` , `dest_region_id` , `dest_zip` , `condition_name` , `condition_to_value` , `delivery_type` , `stock_id` )
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    
// Insert a list of states into the regions database if not exist.
$regions = array(
    array('code' => 'ACT', 'name' => 'Australia Capital Territory'),
    array('code' => 'NSW', 'name' => 'New South Wales'),
    array('code' => 'NT', 'name' => 'Northern Territory'),
    array('code' => 'QLD', 'name' => 'Queensland'),
    array('code' => 'SA', 'name' => 'South Australia'),
    array('code' => 'TAS', 'name' => 'Tasmania'),
    array('code' => 'VIC', 'name' => 'Victoria'),
    array('code' => 'WA', 'name' => 'Western Australia')
);

$db = Mage::getSingleton('core/resource')->getConnection('core_read');

foreach($regions as $region) {
    // Check if this region has already been added
    $result = $db->fetchOne("SELECT code FROM " . $this->getTable('directory_country_region') . " WHERE `country_id` = 'AU' AND `code` = '" . $region['code'] . "'");
    if($result != $region['code']) {
        $installer->run(
            "INSERT INTO `{$this->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
            ('AU', '" . $region['code'] . "', '" . $region['name'] . "');
            INSERT INTO `{$this->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
            ('en_US', LAST_INSERT_ID(), '" . $region['name'] . "'), ('en_AU', LAST_INSERT_ID(), '" . $region['name'] . "');"
        );
    }
}