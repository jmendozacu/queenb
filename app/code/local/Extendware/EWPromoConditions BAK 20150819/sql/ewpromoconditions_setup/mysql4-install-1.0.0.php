<?php
Mage::helper('ewcore/cache')->clean();
$installer = $this;
$installer->startSetup();

$sql = sprintf('SHOW COLUMNS FROM `%s`', $this->getTable('salesrule/rule'));
$columns = $this->getConnection()->fetchCol($sql);

$command = '';
if (in_array('extendware_product_skus', $columns) === false) {
	$command .= 'ALTER TABLE `salesrule` ADD `extendware_product_skus` TEXT NOT NULL;';
}

if (in_array('extendware_category_ids', $columns) === false) {
	$command .= 'ALTER TABLE `salesrule` ADD `extendware_category_ids` TEXT NOT NULL;';
}

if (in_array('extendware_max_applications', $columns) === false) {
	$command .= 'ALTER TABLE `salesrule` ADD `extendware_max_applications` INTEGER UNSIGNED NOT NULL;';
}

if (in_array('extendware_stop_trigger_exceptions', $columns) === false) {
	$command .= 'ALTER TABLE `salesrule` ADD `extendware_stop_trigger_exceptions` TEXT NOT NULL;';
}

if (in_array('extendware_stop_exceptions', $columns) === false) {
	$command .= 'ALTER TABLE `salesrule` ADD `extendware_stop_exceptions` TEXT NOT NULL;';
}
if (in_array('extendware_product_add_type', $columns) === false) {
	$command .= 'ALTER TABLE `salesrule` ADD `extendware_product_add_type` VARCHAR(255) NOT NULL;';
}

if (Mage::helper('ewcore/environment')->isDemoServer() === true) {
	$command .= "
		INSERT INTO `salesrule` (`rule_id`, `name`, `description`, `from_date`, `to_date`, `uses_per_customer`, `is_active`, `conditions_serialized`, `actions_serialized`, `stop_rules_processing`, `is_advanced`, `product_ids`, `sort_order`, `simple_action`, `discount_amount`, `discount_qty`, `discount_step`, `simple_free_shipping`, `apply_to_shipping`, `times_used`, `is_rss`, `coupon_type`, `use_auto_generation`, `uses_per_coupon`, `extendware_product_skus`, `extendware_category_ids`, `extendware_max_applications`, `extendware_stop_trigger_exceptions`, `extendware_stop_exceptions`, `extendware_product_add_type`) VALUES (200,'Example rule with conditions','Click \"Conditions\" to the left to view the special conditions added to this rule',NULL,NULL,0,1,'a:7:{s:4:\"type\";s:32:\"salesrule/rule_condition_combine\";s:9:\"attribute\";N;s:8:\"operator\";N;s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"all\";s:10:\"conditions\";a:1:{i:0;a:7:{s:4:\"type\";s:68:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer_Subselect\";s:9:\"attribute\";s:8:\"customer\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:2:\"==\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"all\";s:10:\"conditions\";a:5:{i:0;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:11:\"account_age\";s:8:\"operator\";s:2:\">=\";s:5:\"value\";a:2:{s:16:\"period_magnitude\";i:1;s:11:\"period_type\";s:5:\"month\";}s:18:\"is_value_processed\";b:1;}i:1;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:16:\"number_of_orders\";s:8:\"operator\";s:2:\">=\";s:5:\"value\";a:3:{s:5:\"value\";d:1;s:16:\"period_magnitude\";i:3;s:11:\"period_type\";s:4:\"year\";}s:18:\"is_value_processed\";b:1;}i:2;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:24:\"average_amount_purchased\";s:8:\"operator\";s:2:\">=\";s:5:\"value\";a:3:{s:5:\"value\";d:10;s:16:\"period_magnitude\";i:3;s:11:\"period_type\";s:4:\"year\";}s:18:\"is_value_processed\";b:1;}i:3;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:16:\"amount_purchased\";s:8:\"operator\";s:2:\">=\";s:5:\"value\";a:3:{s:5:\"value\";d:100;s:16:\"period_magnitude\";i:3;s:11:\"period_type\";s:4:\"year\";}s:18:\"is_value_processed\";b:1;}i:4;a:7:{s:4:\"type\";s:66:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer_Combine\";s:9:\"attribute\";N;s:8:\"operator\";N;s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"any\";s:10:\"conditions\";a:4:{i:0;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:9:\"entity_id\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";b:1;}i:1;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:9:\"entity_id\";s:8:\"operator\";s:1:\"<\";s:5:\"value\";s:2:\"10\";s:18:\"is_value_processed\";b:1;}i:2;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:5:\"email\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:20:\"john.doe@example.com\";s:18:\"is_value_processed\";b:1;}i:3;a:5:{s:4:\"type\";s:58:\"Extendware_EWPromoConditions_Model_Rule_Condition_Customer\";s:9:\"attribute\";s:6:\"gender\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:3:\"124\";s:18:\"is_value_processed\";b:0;}}}}}}}','a:6:{s:4:\"type\";s:40:\"salesrule/rule_condition_product_combine\";s:9:\"attribute\";N;s:8:\"operator\";N;s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"all\";}',0,1,NULL,0,'by_percent',15.0000,NULL,0,0,0,0,1,1,0,0,'','',1,'','','all_product');
			
		INSERT INTO `salesrule_website` (`rule_id`, `website_id`) VALUES (200,1);
			
		INSERT INTO `salesrule_customer_group` (`rule_id`, `customer_group_id`) VALUES (200,0);
		INSERT INTO `salesrule_customer_group` (`rule_id`, `customer_group_id`) VALUES (200,1);
		INSERT INTO `salesrule_customer_group` (`rule_id`, `customer_group_id`) VALUES (200,2);
		INSERT INTO `salesrule_customer_group` (`rule_id`, `customer_group_id`) VALUES (200,3);
		INSERT INTO `salesrule_customer_group` (`rule_id`, `customer_group_id`) VALUES (200,4);
	";
}

$command = @preg_replace('/(EXISTS\s+`)([a-z0-9\_]+?)(`)/ie', '"\\1" . $this->getTable("\\2") . "\\3"', $command);
$command = @preg_replace('/(ON\s+`)([a-z0-9\_]+?)(`)/ie', '"\\1" . $this->getTable("\\2") . "\\3"', $command);
$command = @preg_replace('/(REFERENCES\s+`)([a-z0-9\_]+?)(`)/ie', '"\\1" . $this->getTable("\\2") . "\\3"', $command);
$command = @preg_replace('/(TABLE\s+`)([a-z0-9\_]+?)(`)/ie', '"\\1" . $this->getTable("\\2") . "\\3"', $command);
$command = @preg_replace('/(INTO\s+`)([a-z0-9\_]+?)(`)/ie', '"\\1" . $this->getTable("\\2") . "\\3"', $command);
$command = @preg_replace('/(FROM\s+`)([a-z0-9\_]+?)(`)/ie', '"\\1" . $this->getTable("\\2") . "\\3"', $command);

if ($command) $installer->run($command);
$installer->endSetup(); 