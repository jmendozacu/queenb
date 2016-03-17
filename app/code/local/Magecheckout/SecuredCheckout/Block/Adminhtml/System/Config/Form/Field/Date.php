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
class Magecheckout_SecuredCheckout_Block_Adminhtml_System_Config_Form_Field_Date extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * add date picker to setting
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return type
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        try {
            $date   = new Varien_Data_Form_Element_Date;
            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

            $data = array(
                'name'    => $element->getName(),
                'html_id' => $element->getId(),
                'image'   => $this->getSkinUrl('images/grid-cal.gif'),
            );
            $date->setData($data);
            $date->setValue($element->getValue(), $format);
            $date->setFormat(Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT));
            try {
                $date->setClass($element->getFieldConfig()->validate->asArray());
            } catch (Exception $e) {
            }
            $date->setForm($element->getForm());

            return $date->getElementHtml();
        } catch (Exception $e) {
        }
    }
}