<?php
class Queenb_Customercusexport_Block_Adminhtml_Customercusexport extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customercusexport';
    $this->_blockGroup = 'customercusexport';
    $this->_headerText = Mage::helper('customercusexport')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('customercusexport')->__('Add Item');
    parent::__construct();
  }
}