<?php
class Extendware_EWPromoConditions_Helper_Data extends Extendware_EWCore_Helper_Data_Abstract {
	public function getHistoricalAccountValue($customerId, $periodMagnitude = 0, $periodType = 'alltime') {
		static $cache = array();
		if (!$customerId) return 0;
		$cacheKey = $customerId . '-' . $periodMagnitude . '-' . $periodType;
		if (isset($cache[$cacheKey])) return $cache[$cacheKey];
		if ($periodMagnitude == 0 and $periodType != 'alltime') return 0;
		
		$dbConnection = Mage::getModel('sales_entity/order')->getReadConnection();
    	$select = $dbConnection->select();
    	
		$select->from(array('sales' => Mage::getSingleton('core/resource')->getTableName('sales_flat_order')), array(
			'ewtotal'   => 'SUM(COALESCE(sales.base_total_paid, 0) - COALESCE(sales.base_total_refunded, 0))',
		))->where('sales.customer_id = ?', $customerId);
		
		if ($periodType != 'alltime') {
			$select->where('sales.created_at > ?', date('Y-m-d H:i:s', strtotime(now() . ' - ' . $periodMagnitude . ' ' . $periodType)));
		}
		$select->group('sales.customer_id');
		
		$cache[$cacheKey] = (float)$dbConnection->fetchOne($select);
		
		return $cache[$cacheKey];
	}
	
	public function getNumberOfOrders($customerId, $periodMagnitude = 0, $periodType = 'alltime') {
		static $cache = array();
		if (!$customerId) return 0;
		$cacheKey = $customerId . '-' . $periodMagnitude . '-' . $periodType;
		if (isset($cache[$cacheKey])) return $cache[$cacheKey];
		if ($periodMagnitude == 0 and $periodType != 'alltime') return 0;
		
		$dbConnection = Mage::getModel('sales_entity/order')->getReadConnection();
    	$select = $dbConnection->select();
    	
		$select->from(array('sales' => Mage::getSingleton('core/resource')->getTableName('sales_flat_order')), array(
			'ewtotal'   => 'COUNT(*)',
		))->where('sales.customer_id = ?', $customerId);
		
		$orderStates = $this->mHelper('config')->getAllowedOrderStates();
		if (empty($orderStates) === false) {
			$sql = null;
			foreach ($orderStates as $orderState) {
				if ($sql) $sql .= ' OR ';
				$sql .= $select->getAdapter()->quoteInto('sales.state = ?', $orderState);
			}
			$sql = '(' . $sql . ')';
			$select->where($sql);
		}

		if ($periodType != 'alltime') {
			$select->where('sales.created_at > ?', date('Y-m-d H:i:s', strtotime(now() . ' - ' . $periodMagnitude . ' ' . $periodType)));
		}
		
		$amounts = $dbConnection->fetchCol($select);
		$cache[$cacheKey] = array_sum($amounts);
		return $cache[$cacheKey];
	}
	
	public function getHistoricalOrderValue($customerId, $periodMagnitude = 0, $periodType = 'alltime') {
		static $cache = array();
		if (!$customerId) return 0;
		$cacheKey = $customerId . '-' . $periodMagnitude . '-' . $periodType;
		if (isset($cache[$cacheKey])) return $cache[$cacheKey];
		if ($periodMagnitude == 0 and $periodType != 'alltime') return 0;
		
		$dbConnection = Mage::getModel('sales_entity/order')->getReadConnection();
    	$select = $dbConnection->select();
    	
		$select->from(array('sales' => Mage::getSingleton('core/resource')->getTableName('sales_flat_order')), array(
			'ewtotal'   => '(COALESCE(sales.base_total_paid, 0) - COALESCE(sales.base_total_refunded, 0)) as amount',
		))->where('sales.customer_id = ?', $customerId);
		
		if ($periodType != 'alltime') {
			$select->where('sales.created_at > ?', date('Y-m-d H:i:s', strtotime(now() . ' - ' . $periodMagnitude . ' ' . $periodType)));
		}
		
		$amounts = $dbConnection->fetchCol($select);
		$cache[$cacheKey] = array_sum($amounts) / count($amounts);
		return $cache[$cacheKey];
	}
	
	public function getAccountCreationTime($customerId) {
		static $cache = array();
		if (!$customerId) return time();
		$cacheKey = $customerId;
		if (isset($cache[$cacheKey])) return $cache[$cacheKey];
		
		$dbConnection = Mage::getModel('sales_entity/order')->getReadConnection();
    	$select = $dbConnection->select();
    	
		$select->from(array('customer' => Mage::getSingleton('core/resource')->getTableName('customer_entity')), array(
			'ewcreated_date' => 'customer.created_at',
		));                    
		$select->where('customer.entity_id = ?', $customerId);
		
		$createdAt = $dbConnection->fetchOne($select);
		$cache[$cacheKey] = (int)strtotime($createdAt);
		return $cache[$cacheKey];
	}
}