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
 * @package     Magecheckout_CheckoutPromotion
 * @copyright   Copyright (c) 2014 Magecheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * @category   Magecheckout
 * @package    Magecheckout_SecuredCheckout
 */
class Magecheckout_SecuredCheckout_Block_Adminhtml_Customblock_Shoppingcart extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_customblock_shoppingcart';
        $this->_blockGroup = 'securedcheckout';
        $this->_headerText = Mage::helper('securedcheckout')->__('Shopping Cart Rule Blocks');
        $this->_addButtonLabel = Mage::helper('securedcheckout')->__('Add Block');
        parent::__construct();
    }
}