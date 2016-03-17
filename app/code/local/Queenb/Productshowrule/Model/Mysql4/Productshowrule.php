<?php

class Queenb_Productshowrule_Model_Mysql4_Productshowrule extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productshowrule_id refers to the key field in your database table.
        $this->_init('productshowrule/productshowrule', 'productshowrule_id');
    }
}