<?php
if(!defined('LINKSYNC_EPARCEL_URL1'))
	define('LINKSYNC_EPARCEL_URL1','ws1.linksync.com');
if(!defined('LINKSYNC_URL2'))
	define('LINKSYNC_URL2','ws2.linksync.com');
if(!defined('LINKSYNC_WSDL'))
	define('LINKSYNC_WSDL','/linksync/linksyncService');
if(!defined('LINKSYNC_DEBUG'))
	define('LINKSYNC_DEBUG',1);
class Linksync_Linksynceparcel_Model_Api extends Mage_Core_Model_Abstract
{
	public function isAddressValid($address)
	{
		try
		{
			if(is_object($address))
			{
				$city = $address->getCity();
				$state = Mage::helper('linksynceparcel')->getRegion($address->getRegionId());
				$postcode = $address->getPostcode();
				
				if(LINKSYNC_DEBUG == 1)
				{
					$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
				}
				else
				{
					$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
				}
				
				$laid = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid'));
				$addressParams = array('suburb' => trim($city), 'postcode' => trim($postcode), 'stateCode' => trim($state));
				
				$stdClass = $client->isAddressValid($laid,$addressParams); 

				if($stdClass)
				{
					if(LINKSYNC_DEBUG == 1)
					{
						Mage::log('isAddressValid Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
						Mage::log('isAddressValid Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
					}
					return 1;
				}
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('isAddressValid Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('isAddressValid Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			return $e->getMessage();
		}
	}
	
	public function getWebserviceUrl($next = false)
	{
		$url = 'https://';
		
		if($next)
		{
			$url .= LINKSYNC_EPARCEL_URL1;
		}
		else
		{
			$url .= LINKSYNC_URL2;
		}
		$url .= LINKSYNC_WSDL;
		return $url;
	}
	
	public function createConsignment($article,$loop=0)
	{
		if($loop < 2)
		{
			try
			{
				if(LINKSYNC_DEBUG == 1)
				{
					$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
				}
				else
				{
					$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
				}
				
				Mage::log('Articles: '.preg_replace('/\s+/', ' ', trim($article)), null, 'linksync_eparcel.log', true);
				
				$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
				
				$stdClass = $client->createConsignment2($laid,$article); 
	
				if($stdClass)
				{
					if(LINKSYNC_DEBUG == 1)
					{
						//Mage::log('createConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
						Mage::log('createConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
					}
					return $stdClass;
				}
			}
			catch(Exception $e)
			{
				if(LINKSYNC_DEBUG == 1 && $client)
				{
					Mage::log('createConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('createConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				Mage::log('createConsignment Error catch from API class: '.$e->getMessage(), null, 'linksync_eparcel.log', true);
				throw $e;
			}
		}
	}
	
	public function modifyConsignment($article,$consignmentNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			Mage::log('Modified Articles: '.preg_replace('/\s+/', ' ', trim($article)), null, 'linksync_eparcel.log', true);
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->modifyConsignment2($laid,$consignmentNumber,$article);

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					//Mage::log('modifyConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('modifyConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('modifyConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('modifyConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('modifyConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('modifyConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function unAssignConsignment($consignmentNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->unAssignConsignment($laid,$consignmentNumber);

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('unAssignConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('unAssignConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('unAssignConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('unAssignConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('unAssignConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('unAssignConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function deleteConsignment($consignmentNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->deleteConsignment($laid,$consignmentNumber);

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('deleteConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('deleteConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('deleteConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('deleteConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('deleteConsignment Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('deleteConsignment Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function assignConsignmentToManifest($consignmentNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->assignConsignmentToManifest($laid,$consignmentNumber);

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('assignConsignmentToManifest Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('assignConsignmentToManifest Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('assignConsignmentToManifest Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('assignConsignmentToManifest Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('assignConsignmentToManifest Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('assignConsignmentToManifest Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function seteParcelMerchantDetails()
	{
		try
		{
			$this->getWebserviceUrl(true).'?WSDL';
	
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid'));
			$merchant_location_id = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/merchant_location_id'));
			$post_charge_to_account = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/post_charge_to_account'));
			$sftp_username = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/sftp_username'));
			$sftp_password = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/sftp_password'));
			$operation_mode = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/operation_mode');
			if($operation_mode == 2)
			{
				$operation_mode = 'test';
			}
			else
			{
				$operation_mode = 'live';
			}
			
			$label_logo = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/label_logo');
			$logoPath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$logoPath .= 'media/linksync/';
			$label_logo = @file_get_contents($logoPath.$label_logo);

			$merchant_id = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/merchant_id'));
			$lodgement_facility = trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/lodgement_facility'));
			
			$stdClass = $client->seteParcelMerchantDetails($laid,$merchant_location_id, $post_charge_to_account,$sftp_username,$sftp_password, $operation_mode, '', $merchant_id, $lodgement_facility, $label_logo ); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('seteParcelMerchantDetails Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('seteParcelMerchantDetails Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('seteParcelMerchantDetails Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('seteParcelMerchantDetails Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('seteParcelMerchantDetails Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('seteParcelMerchantDetails Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function setReturnAddress()
	{
		try
		{
			$this->getWebserviceUrl(true).'?WSDL';
	
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$returnAddress = array();
			$returnAddress['returnAddressLine1'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_line1'));
			$returnAddress['returnAddressLine2'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_line2'));
			$returnAddress['returnAddressLine3'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_line3'));
			$returnAddress['returnAddressLine4'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_line4'));
			$returnAddress['returnCountryCode'] = 'AU';
			$returnAddress['returnName'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_name'));
			$returnAddress['returnPostcode'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_postcode'));
			$returnAddress['returnStateCode'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_statecode'));
			$returnAddress['returnSuburb'] = trim(Mage::getStoreConfig('carriers/linksynceparcel/return_address_suburb'));
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->setReturnAddress($laid,$returnAddress); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('setReturnAddress Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('setReturnAddress Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('setReturnAddress Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('setReturnAddress Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('setReturnAddress Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('setReturnAddress Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function getArticles($consignmentNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->getArticles($laid,$consignmentNumber); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getArticles Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('getArticles Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getArticles Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getArticles Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getArticles Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getArticles Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function getManifest()
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->getManifest($laid); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getManifest Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					//Mage::log('getManifest Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getManifest Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getManifest Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getManifest Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getManifest Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function getNotDespatchedConsignments()
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->getNotDespatchedConsignments($laid); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getNotDespatchedConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('getNotDespatchedConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass->consignments;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getNotDespatchedConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getNotDespatchedConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				@Mage::log('getNotDespatchedConsignmentsResponse  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				@Mage::log('getNotDespatchedConsignmentsResponse  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			return $e->getMessage();
		}
	}
	
	public function getReturnLabels()
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			$labelType = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/label_format');
			$stdClass = $client->getReturnLabels($laid,$labelType); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getReturnLabels  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					//Mage::log('getReturnLabels  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getReturnLabels  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getReturnLabels  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getReturnLabels  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getReturnLabels  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function getLabelsByConsignments($consignments)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			$labelType = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/label_format');
			
			$stdClass = $client->getLabelsByConsignments($laid,explode(',',$consignments),$labelType); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getLabelsByConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					//Mage::log('getLabelsByConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getLabelsByConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getLabelsByConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getLabelsByConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getLabelsByConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function getReturnLabelsByConsignments($consignments)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			$labelType = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/label_format');
			
			$stdClass = $client->getReturnLabelsByConsignments($laid,explode(',',$consignments),$labelType); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getReturnLabelsByConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					//Mage::log('getReturnLabelsByConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getReturnLabelsByConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getReturnLabelsByConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getReturnLabelsByConsignments  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getReturnLabelsByConsignments  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function despatchManifest()
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->despatchManifest($laid); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('despatchManifest  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('despatchManifest  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('despatchManifest  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('despatchManifest  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('despatchManifest  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('despatchManifest  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function printManifest($manifestNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
			$stdClass = $client->printManifest($laid,$manifestNumber); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('printManifest  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					//Mage::log('printManifest  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
			
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('printManifest  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('printManifest  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('printManifest  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('printManifest  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function sendLog($manifestNumber)
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			
	    	$file = Mage::getBaseDir().DS.'var'.DS.'log'.DS.'linksync_eparcel_log_'.date('Ymdhis').'.zip';
			
			if(Mage::helper('linksynceparcel')->createZip(__DIR__.'/../../../../../../var/log/linksync_eparcel.log',$file))
			{
				$stdClass = $client->sendLogFile($laid,file_get_contents($file)); 
	
				if($stdClass)
				{
					if(LINKSYNC_DEBUG == 1)
					{
						//Mage::log('sendLogFile  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
						Mage::log('sendLogFile  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
					}
					return $stdClass;
				}
				
				if(LINKSYNC_DEBUG == 1 && $client)
				{
					Mage::log('sendLogFile  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('sendLogFile  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
			}
			else
			{
				throw new Exception('Failed to create archive file');
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('sendLogFile  Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('sendLogFile  Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			throw $e;
		}
	}
	
	public function getVersionNumber()
	{
		try
		{
			if(LINKSYNC_DEBUG == 1)
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL',array('trace'=>1));
			}
			else
			{
				$client = new SoapClient($this->getWebserviceUrl(true).'?WSDL');
			}
			
			$laid = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/laid');
			$stdClass = $client->getVersionNumber($laid); 

			if($stdClass)
			{
				if(LINKSYNC_DEBUG == 1)
				{
					Mage::log('getVersionNumber Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
					Mage::log('getVersionNumber Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
				}
				return $stdClass;
			}
		}
		catch(Exception $e)
		{
			if(LINKSYNC_DEBUG == 1 && $client)
			{
				Mage::log('getVersionNumber Request: '.$client->__getLastRequest(), null, 'linksync_eparcel.log', true);
				Mage::log('getVersionNumber Response: '.$client->__getLastResponse(), null, 'linksync_eparcel.log', true);
			}
			return $e->getMessage();
		}
	}
}