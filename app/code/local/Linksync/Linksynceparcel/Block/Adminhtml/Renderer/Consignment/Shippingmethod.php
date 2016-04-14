<?php
 
class Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Shippingmethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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
		$method =  $row->getData('shipping_description');
		$display = $method.' - '.$chargeCode;
		return $display;
	}
}
