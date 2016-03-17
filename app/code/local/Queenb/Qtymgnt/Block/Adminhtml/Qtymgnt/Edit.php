<?php

class Queenb_Qtymgnt_Block_Adminhtml_Qtymgnt_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'qtymgnt';
        $this->_controller = 'adminhtml_qtymgnt';
        
        $this->_updateButton('save', 'label', Mage::helper('qtymgnt')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('qtymgnt')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('qtymgnt_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'qtymgnt_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'qtymgnt_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('qtymgnt_data') && Mage::registry('qtymgnt_data')->getId() ) {
            return Mage::helper('qtymgnt')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('qtymgnt_data')->getTitle()));
        } else {
            return Mage::helper('qtymgnt')->__('Add Item');
        }
    }
}