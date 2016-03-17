<?php
class Magecheckout_SecuredCheckout_Model_Delivery extends Mage_Core_Model_Abstract
{	
	public function _construct()	
	{
		parent::_construct();
		$this->_init('securedcheckout/delivery');
	}	
}