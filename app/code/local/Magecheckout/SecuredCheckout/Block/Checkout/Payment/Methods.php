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
class Magecheckout_SecuredCheckout_Block_Checkout_Payment_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods
{
    /**
     * @return string
     */
    public function getSavePaymentUrl()
    {
        $isSecure = Mage::app()->getStore()->isCurrentlySecure();

        return Mage::getUrl('securedcheckout/checkout/savePayment', array('_secure' => $isSecure));
    }
}