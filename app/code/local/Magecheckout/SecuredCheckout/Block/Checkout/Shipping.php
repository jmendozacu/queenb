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
class Magecheckout_SecuredCheckout_Block_Checkout_Shipping extends Magecheckout_SecuredCheckout_Block_Checkout_Address
{
    /**
     * get installed Store Pickup
     *
     * @return bool
     */
    public function isEnabledStorePickup()
    {
        return (Mage::helper('securedcheckout')->isModuleEnabled('Magecheckout_Storepickup')
            && Mage::helper('storepickup')->isEnabled());
    }
}