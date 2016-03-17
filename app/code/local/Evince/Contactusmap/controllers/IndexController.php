<?php

require_once("Mage/Contacts/controllers/IndexController.php");
class Evince_Contactusmap_IndexController extends Mage_Contacts_IndexController
{

    public function indexAction()

    {
      
     $this->loadLayout();
    
      $getlayout = Mage::helper('contactusmap')->getlayout();
       $this->getLayout()->getBlock('root')->setTemplate('page/'.$getlayout.'.phtml');
       $this->_initLayoutMessages('customer/session');
       $this->_initLayoutMessages('catalog/session');
       $this->renderLayout();  
        
    }
    
   

}
