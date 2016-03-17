<?php

class Queenb_Qtymgnt_Model_Qtymgnt extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qtymgnt/qtymgnt');
    }
}