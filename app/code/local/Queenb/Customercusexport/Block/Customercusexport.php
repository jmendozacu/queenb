<?php
class Queenb_Customercusexport_Block_Customercusexport extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCustomercusexport()     
     { 
        if (!$this->hasData('customercusexport')) {
            $this->setData('customercusexport', Mage::registry('customercusexport'));
        }
        return $this->getData('customercusexport');
        
    }
}