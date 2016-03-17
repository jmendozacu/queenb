<?php
/**
 * MageCheckout
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MageCheckout.com license that is
 * available through the world-wide-web at this URL:
 * http://magecheckout.com/license-agreement/
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    MageCheckout
 * @package     MageCheckout_CheckoutPromotion
 * @copyright   Copyright (c) 2014 MageCheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * SecuredCheckout Resource Model
 * 
 * @category    MageCheckout
 * @package     Magecheckout_Onestepcheckou
 * @author      MageCheckout Developer
 */
class Magecheckout_SecuredCheckout_Model_Mysql4_Customblock_Shoppingcart extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('securedcheckout/customblock_shoppingcart', 'rule_id');
    }
}