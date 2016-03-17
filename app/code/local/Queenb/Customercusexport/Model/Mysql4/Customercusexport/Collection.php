<?php

class Queenb_Customercusexport_Model_Mysql4_Customercusexport_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customercusexport/customercusexport');
    }
}