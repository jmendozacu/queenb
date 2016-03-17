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

/**
 * CustomerAttributes Edit Form Content Tab Block
 *
 * @category    Magecheckout
 * @package     Magecheckout_SecuredCheckout
 * @author      Magecheckout Developer
 */
class Magecheckout_SecuredCheckout_Block_Adminhtml_Field_Position extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSortedFields()
    {
        return Mage::getModel('securedcheckout/attribute')->getSortedFields();
    }

    public function getAvailableFields()
    {
        return Mage::getModel('securedcheckout/attribute')->getAvailableFields();
    }
}
