<?php

class Queenb_Qtymgnt_Model_Mysql4_Qtymgnt extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the qtymgnt_id refers to the key field in your database table.
        $this->_init('qtymgnt/qtymgnt', 'qtymgnt_id');
    }
}