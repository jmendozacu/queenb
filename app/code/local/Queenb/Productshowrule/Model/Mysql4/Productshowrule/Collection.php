<?php

class Queenb_Productshowrule_Model_Mysql4_Productshowrule_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productshowrule/productshowrule');
    }
}