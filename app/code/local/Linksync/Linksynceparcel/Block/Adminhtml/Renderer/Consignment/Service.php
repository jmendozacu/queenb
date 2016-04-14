<?php
 
class Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Service extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		$value =  $row->getData('order_consignment');
		$values = explode('_',$value);
		$orderId = $values[0];
		$order = Mage::getModel('sales/order')->load($orderId);
		$chargeCode = $row->getData('general_linksynceparcel_shipping_chargecode');
		if(!$chargeCode) {
			$chargeCode = Mage::helper('linksynceparcel')->getChargeCode($order);
		}
		$chargeCodes = Mage::helper('linksynceparcel')->getChargeCodes();
		$chargeCodeData = $chargeCodes[$chargeCode];
		switch($chargeCodeData['serviceType']) {
			case 'express':
				$color = 'f66a1e';
				break;
			case 'standard':
				$color = 'ffa10c';
				break;
			case 'international':
				$color = '4487f5';
				break;
		}
		$html = '<p style="background-color: #'. $color .';color: #fff;text-align: center;border-radius: 10px;font-weight: 600;">'. ucfirst($chargeCodeData['service']) .'</p>';
		return $html;
	}
}
