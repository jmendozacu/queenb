<?php

class Queenb_Qtymgnt_Block_Adminhtml_Qtymgnt_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('qtymgnt_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('qtymgnt')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('qtymgnt')->__('Item Information'),
          'title'     => Mage::helper('qtymgnt')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('qtymgnt/adminhtml_qtymgnt_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}