<?php

class Queenb_Productshowrule_Block_Adminhtml_Productshowrule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productshowrule';
        $this->_controller = 'adminhtml_productshowrule';
        
        $this->_updateButton('save', 'label', Mage::helper('productshowrule')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productshowrule')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productshowrule_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productshowrule_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productshowrule_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productshowrule_data') && Mage::registry('productshowrule_data')->getId() ) {
            return Mage::helper('productshowrule')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('productshowrule_data')->getTitle()));
        } else {
            return Mage::helper('productshowrule')->__('Add Item');
        }
    }
}