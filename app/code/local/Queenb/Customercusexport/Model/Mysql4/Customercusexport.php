<?php

class Queenb_Customercusexport_Model_Mysql4_Customercusexport extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customercusexport_id refers to the key field in your database table.
        $this->_init('customercusexport/customercusexport', 'customercusexport_id');
    }
}