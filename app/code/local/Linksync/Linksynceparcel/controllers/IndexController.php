<?php

class Linksync_Linksynceparcel_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$resource = Mage::getSingleton('core/resource');
	    $writeConnection = $resource->getConnection('core_write');
		
	    /*$table = $resource->getTableName('linksync_linksynceparcel_nonlinksync');

		$query = "CREATE TABLE IF NOT EXISTS ".$table." (
			`id` int(11) NOT NULL auto_increment,
			`method` varchar(255) NOT NULL,
			`charge_code` varchar(255) NOT NULL,
			PRIMARY KEY  (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$writeConnection->query($query);*/
		
		/*$table = $resource->getTableName('linksync_linksynceparcel_consignment');

		$query = "ALTER TABLE  `".$table."` ADD weight varchar(20)";
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
		
		echo 'It works!';
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
		Mage::helper('linksynceparcel')->updateConsignmentTable2($consignmentNumber,'is_label_printed', 1);
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