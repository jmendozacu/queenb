<?php
/**
 * Magecheckout
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the magecheckout.com license that is
 * available through the world-wide-web at this URL:
 * http://magecheckout.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magecheckout
 * @package     Magecheckout_SecuredCheckout
 * @copyright   Copyright (c) 2014 Magecheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 *
 * @category    Magecheckout
 * @package     Magecheckout_SecuredCheckout
 * @author      Magecheckout Developer
 */
class Magecheckout_SecuredCheckout_Block_Customblock_Page_Checkoutsuccess extends Magecheckout_SecuredCheckout_Block_Customblock_Abstract
{
    public function __construct()
    {
        $quoteId      = Mage::getSingleton('checkout/session')->getLastQuoteId();
        $this->_quote = Mage::getModel('sales/quote')->loadByIdWithoutStore($quoteId);
        parent::__construct();
    }
}