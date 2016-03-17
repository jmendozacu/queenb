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
 * SecuredCheckout Adminhtml Controller
 *
 * @category    Magecheckout
 * @package     Magecheckout_SecuredCheckout
 * @author      Magecheckout Developer
 */
class Magecheckout_SecuredCheckout_Block_Adminhtml_System_Config_Form_Field_Emailchain
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element
            ->setName($element->getName() . '[]');

        if ($element->getValue()) {
            $values = explode(',', $element->getValue());
        } else {
            $values = array();
        }
        $days    = $element->setStyle('width:10%;')->setValue(isset($values[0]) ? $values[0] : null)->getElementHtml();
        $hours   = $element->setStyle('width:10%;')->setValue(isset($values[1]) ? $values[1] : null)->getElementHtml();
        $minutes = $element->setStyle('width:10%;')->setValue(isset($values[2]) ? $values[2] : null)->getElementHtml();

        return $days . $this->__('day(s)') . $hours.$this->__('hour(s)').$minutes.$this->__('minute(s)');
    }
}