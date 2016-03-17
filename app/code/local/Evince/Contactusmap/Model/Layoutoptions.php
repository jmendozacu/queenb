<?php

class Evince_Contactusmap_Model_Layoutoptions
{

   
 public function toOptionArray(){
       return array(
                    array('value' => '1column', 'label'=>Mage::helper('contactusmap')->__('1column')),
                    array('value' => '2columns-left', 'label'=>Mage::helper('contactusmap')->__('2columns-left')),
                    array('value' => '2columns-right', 'label'=>Mage::helper('contactusmap')->__('2columns-right')),
                    array('value' => '3columns', 'label'=>Mage::helper('contactusmap')->__('3columns'))
        );   
    
 }
 
 }
