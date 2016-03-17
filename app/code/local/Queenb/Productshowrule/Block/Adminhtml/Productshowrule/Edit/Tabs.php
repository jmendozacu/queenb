<?php

class Queenb_Productshowrule_Block_Adminhtml_Productshowrule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productshowrule_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productshowrule')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productshowrule')->__('Item Information'),
          'title'     => Mage::helper('productshowrule')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('productshowrule/adminhtml_productshowrule_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}