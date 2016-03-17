<?php

	require_once('app/Mage.php');
	Mage::app('default');
	Mage::getSingleton('core/session', array('name' => 'frontend'));
	Mage::register('isSecureArea', 0);
	
	for($i=1;$i<6000;$i++):
		$customer = Mage::getModel('customer/customer')->load($i);
		
		$customerArray = $customer->toArray();
		
		//print_r($customer->toArray());
		if(!isset($customerArray['entity_id'])):
			continue;
		endif;
			
		
		$customer->setHowFindUsType(1);
		$customer->setHowFindUsValue('Google');
		$customer->save();
		
		echo '<br>' . $i;
	endfor;
	/*
	echo '<pre>';
	
	print_r($customer->toArray());
	
	echo '</pre>';
	*/
	?>