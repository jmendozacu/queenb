<?php
$paths = array(
    dirname(dirname(dirname(dirname(__FILE__)))) . '/app/Mage.php',
    '../../../app/Mage.php',
    '../../app/Mage.php',
    '../app/Mage.php',
    'app/Mage.php',
);

foreach ($paths as $path) {
    if (file_exists($path)) {
        require $path; 
        break;
    }
}

Mage::app('admin')->setUseSessionInUrl(false);
error_reporting(E_ALL | E_STRICT);
if (file_exists(BP.DS.'maintenance.flag')) exit;
if (class_exists('Extendware') === false) exit;
if (Extendware::helper('ewgppercent') === false) exit;
if (!isset($argv) or !is_array($argv)) $argv = array();
if (isset($_SERVER['REQUEST_METHOD'])) {
	die('This should be run through shell and not the web server');
}

// $productIds = Mage::getModel('catalog/product')->getCollection()->getAllIds();
$productIds = Mage::getModel('ewgppercent/tier_price')->getCollection()->getColumnValues('entity_id');
$productIds = array_merge($productIds, Mage::getModel('ewgppercent/group_price')->getCollection()->getColumnValues('entity_id'));
$productIds = array_unique($productIds);
// this will remove the first 100 product ids and return the remaining
// useful if you need to run the script multiple times
// $productIds = array_slice($productIds, 100);
$cnt = 1;
foreach ($productIds as $productId) {
	echo $cnt . ' - ' . $productId . "\n";
	try {
		$product = Mage::getModel('catalog/product')->load($productId);
		$product->setOrigData('price', $product->getData('price') + 0.01); // ensure prices are recalcuated
		$product->setOrigData('cost', $product->getData('cost') + 0.01); // ensure prices are recalcuated
		$product->getResource()->getAttribute('tier_price')->getBackend()->loadEWData($product);
		$product->getResource()->getAttribute('group_price')->getBackend()->loadEWData($product);
		$product->save();
		$cnt++;
	} catch (Exception $e) {
		Mage::logException($e);
	}
}
