<?php
class Queenb_Productshowrule_Block_Productshowrule extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getProductshowrule()     
     { 
        if (!$this->hasData('productshowrule')) {
            $this->setData('productshowrule', Mage::registry('productshowrule'));
        }
        return $this->getData('productshowrule');
        
    }
	public function loadcheckproductdata($productid) {
		if(Mage::helper('core')->isModuleEnabled('Queenb_Productshowrule')){
				
				if(Mage::getSingleton( 'customer/session' )->isLoggedIn()){
					$groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
				}
				else
				{
					$groupId=0;
				}
				$productarray=array();
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
				$readresultweight=$write->query("select productid from  mg_productshowrule where cusgroupid ='$groupId' and productid='".$productid."'");
				$AllDataresults=$readresultweight->fetchAll();
				if(!count($AllDataresults)){
					$str="no";
				}
				else
				{
					$str="yes";
				}
			}
			else
			{
				$str="no";
			}
			
			return $str;
	}
}