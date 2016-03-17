<?php
 
class Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Addressvalid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		$valid =  $row->getData($this->getColumn()->getIndex());
		if($valid)
		{
			$imgLink = $this->getSkinUrl("linksynceparcel/images/icon-enabled.png");
		}
		else
		{
			$imgLink = $this->getSkinUrl("linksynceparcel/images/cancel_icon.gif");
		}
		$html = '<img src="'.$imgLink.'" />';
		return $html;
	}
}
