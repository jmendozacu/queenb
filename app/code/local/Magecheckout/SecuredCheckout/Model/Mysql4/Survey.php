<?php

class Magecheckout_SecuredCheckout_Model_Mysql4_Survey extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('securedcheckout/survey', 'survey_id');
    }
}