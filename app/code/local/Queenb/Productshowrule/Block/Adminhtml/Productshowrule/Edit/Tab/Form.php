<?php

class Queenb_Productshowrule_Block_Adminhtml_Productshowrule_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productshowrule_form', array('legend'=>Mage::helper('productshowrule')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('productshowrule')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('productshowrule')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('productshowrule')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('productshowrule')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('productshowrule')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('productshowrule')->__('Content'),
          'title'     => Mage::helper('productshowrule')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getProductshowruleData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductshowruleData());
          Mage::getSingleton('adminhtml/session')->setProductshowruleData(null);
      } elseif ( Mage::registry('productshowrule_data') ) {
          $form->setValues(Mage::registry('productshowrule_data')->getData());
      }
      return parent::_prepareForm();
  }
}