<?php

class Queenb_Qtymgnt_Block_Adminhtml_Qtymgnt_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('qtymgnt_form', array('legend'=>Mage::helper('qtymgnt')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('qtymgnt')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('qtymgnt')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('qtymgnt')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('qtymgnt')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('qtymgnt')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('qtymgnt')->__('Content'),
          'title'     => Mage::helper('qtymgnt')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getQtymgntData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getQtymgntData());
          Mage::getSingleton('adminhtml/session')->setQtymgntData(null);
      } elseif ( Mage::registry('qtymgnt_data') ) {
          $form->setValues(Mage::registry('qtymgnt_data')->getData());
      }
      return parent::_prepareForm();
  }
}