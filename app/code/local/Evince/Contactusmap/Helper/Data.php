<?php

class Evince_Contactusmap_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function EnableDisable()
    {
       return Mage::getStoreConfig("contactusmap/contactusmap/contactusmapyesorno");  
    }
    
    public function getAddress()
    {
       return Mage::getStoreConfig("contactusmap/contactusmap/contactusmapaddress"); 
    }
    
    public function getmapheight()
    {
       return Mage::getStoreConfig("contactusmap/contactusmap/contactusmapheight"); 
    }
    
    public function getmapimage()
    {
       return Mage::getStoreConfig("contactusmap/contactusmap/contactusmapmarkerimg"); 
    }
    public function getmapapi()
    {
       return Mage::getStoreConfig("contactusmap/contactusmap/contactusmapapikey"); 
    }
    public function getlayout()
    {
       return Mage::getStoreConfig("contactusmap/contactusmap/contactusmappagelayout"); 
    }
    
    public function getdefaultstoreaddress()
    {
       return Mage::getStoreConfig("general/store_information/address"); 
    }
    
}