<?php

class Queenb_Customercusexport_Block_Adminhtml_Customercusexport_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customercusexport';
        $this->_controller = 'adminhtml_customercusexport';
        
        $this->_updateButton('save', 'label', Mage::helper('customercusexport')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customercusexport')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customercusexport_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customercusexport_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customercusexport_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customercusexport_data') && Mage::registry('customercusexport_data')->getId() ) {
            return Mage::helper('customercusexport')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('customercusexport_data')->getTitle()));
        } else {
            return Mage::helper('customercusexport')->__('Add Item');
        }
    }
}