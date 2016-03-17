<?php
 
class Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Shippingmethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		$shipping_method =  $row->getData('shipping_method');
		$shipping_method = explode('_',$shipping_method);
		$charge_code = $shipping_method[1];
		
		$method =  $row->getData('shipping_description');
		
		if($shipping_method[0] == 'linksynceparcel')
		{
			$title = Mage::getStoreConfig('carriers/linksynceparcel/title');
			$method = str_replace($title,'',$method);
			$method = str_replace(' - ','',$method);
		}
		
		$display = $method.' - '.$charge_code;
		
		if($shipping_method[0] != 'linksynceparcel')
		{
			$charge_code = $row->getData('general_linksynceparcel_shipping_chargecode');
			if(!empty($charge_code))
			{
				$display = $method.' - '.$charge_code;
			}
			else
			{
				$display = $method;
			}
		}
		return $display;
	}
}
