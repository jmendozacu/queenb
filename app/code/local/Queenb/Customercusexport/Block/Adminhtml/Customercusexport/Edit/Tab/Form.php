<?php

class Queenb_Customercusexport_Block_Adminhtml_Customercusexport_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customercusexport_form', array('legend'=>Mage::helper('customercusexport')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('customercusexport')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('customercusexport')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customercusexport')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customercusexport')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customercusexport')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('customercusexport')->__('Content'),
          'title'     => Mage::helper('customercusexport')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCustomercusexportData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomercusexportData());
          Mage::getSingleton('adminhtml/session')->setCustomercusexportData(null);
      } elseif ( Mage::registry('customercusexport_data') ) {
          $form->setValues(Mage::registry('customercusexport_data')->getData());
      }
      return parent::_prepareForm();
  }
}