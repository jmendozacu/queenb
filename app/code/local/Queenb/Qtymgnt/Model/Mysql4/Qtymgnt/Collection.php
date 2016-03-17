<?php

class Queenb_Qtymgnt_Model_Mysql4_Qtymgnt_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qtymgnt/qtymgnt');
    }
}