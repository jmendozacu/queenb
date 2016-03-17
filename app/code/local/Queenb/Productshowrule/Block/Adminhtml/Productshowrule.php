<?php
class Queenb_Productshowrule_Block_Adminhtml_Productshowrule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_productshowrule';
    $this->_blockGroup = 'productshowrule';
    $this->_headerText = Mage::helper('productshowrule')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('productshowrule')->__('Add Item');
    parent::__construct();
  }
}