<?php
class Linksync_Linksynceparcel_Block_Adminhtml_Consignment extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_consignment';
        $this->_blockGroup = 'linksynceparcel';
        $this->_headerText = Mage::helper('linksynceparcel')->__('Consignments');
		
		$data = array(
		   'label' => 'Despatch',
		   'onclick' => "setLocationConfirmDialogNew('".$this->getUrl('linksynceparcel/adminhtml_consignment/despatch')."')"
        );
		
		if(!Mage::helper('linksynceparcel')->isCurrentMainfestHasConsignmentsForDespatch())
		{
			$data['disabled'] = 'disabled';
		}
		
		$active = (int)Mage::getStoreConfig('carriers/linksynceparcel/active');
		if($active == 1)
		{
			Mage_Adminhtml_Block_Widget_Container::addButton('despatch', $data, 0, 200,  'header', 'header');
		}
		
        parent::__construct();
		$this->removeButton('add');
    }
}
