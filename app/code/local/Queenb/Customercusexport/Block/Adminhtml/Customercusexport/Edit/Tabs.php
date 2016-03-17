<?php

class Queenb_Customercusexport_Block_Adminhtml_Customercusexport_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('customercusexport_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customercusexport')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customercusexport')->__('Item Information'),
          'title'     => Mage::helper('customercusexport')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('customercusexport/adminhtml_customercusexport_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}