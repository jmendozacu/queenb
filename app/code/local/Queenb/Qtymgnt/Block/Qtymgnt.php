<?php
class Queenb_Qtymgnt_Block_Qtymgnt extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getQtymgnt()     
     { 
        if (!$this->hasData('qtymgnt')) {
            $this->setData('qtymgnt', Mage::registry('qtymgnt'));
        }
        return $this->getData('qtymgnt');
        
    }
	
	public function loadqtydata($groupid,$productid)    
    {
		$qtyvalue="";
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$readresultweight=$write->query("select * from mg_qtymgntdetails where customergroup ='$groupid' and productid='$productid' and qtymgnt_id in(select qtymgnt_id from mg_qtymgnt where status='1')");
		$AllDataresults=$readresultweight->fetchAll();
		foreach ($AllDataresults as $result)
		{
			$qtyvalue=$result['qtyvalue'];
		}
		
		return $qtyvalue;
	}
}