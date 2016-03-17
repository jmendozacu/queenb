<?php

/**
 * Magecheckout
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magecheckout.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magecheckout.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magecheckout
 * @package     Magecheckout_SecuredCheckout
 * @copyright   Copyright (c) 2014 Magecheckout (http://www.magecheckout.com/)
 * @license     http://www.magecheckout.com/license-agreement.html
 */
class Magecheckout_SecuredCheckout_Block_Checkout_Review_Term extends Mage_Checkout_Block_Agreements
{

    /**
     * enable gift message or not
     *
     */
    public function canShow()
    {
        return count($this->getTermAndConditions());
    }

    public function getTermAndConditions()
    {
        $agreements        = array();
        $agreementsDefault = $this->getAgreements();
        if (Mage::helper('securedcheckout/config')->isEnabledTerm()) {
            $agreementConfig = array(
                'id'            => 'mc_osc_term',
                'checkbox_text' => Mage::helper('securedcheckout/config')->getTermCheckboxText(),
                'name'         => Mage::helper('securedcheckout/config')->getTermTitle(),
                'content'       => Mage::helper('securedcheckout/config')->getTermContent(),
                'is_html'       => true
            );
            $agreements[]    = new Varien_Object($agreementConfig);
        }
        foreach ($agreementsDefault as $agree) {
            $agreements[] = $agree;
        }

        return $agreements;
    }

    public function isRequiredReadTerm()
    {
        return Mage::helper('securedcheckout/config')->isRequiredReadTerm();
    }

    public function getFormData()
    {
        return Mage::getSingleton('checkout/session')->getData('securedcheckout_form_values');
    }

}