<?php
class Queenb_Qtymgnt_Block_Adminhtml_Qtymgnt extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_qtymgnt';
    $this->_blockGroup = 'qtymgnt';
    $this->_headerText = Mage::helper('qtymgnt')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('qtymgnt')->__('Add Item');
    parent::__construct();
  }
}