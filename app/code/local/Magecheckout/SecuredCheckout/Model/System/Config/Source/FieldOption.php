<?php

/**
 * MageCheckout
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
 * @copyright   Copyright (c) 2014 Magecheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement.html
 */
class Magecheckout_SecuredCheckout_Model_System_Config_Source_FieldOption
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('Hidden')),
            array('value' => 'opt', 'label' => Mage::helper('adminhtml')->__('Optional')),
            array('value' => 'req', 'label' => Mage::helper('adminhtml')->__('Required')),
        );
    }

    public function toOption()
    {
        return array(
            ''   => Mage::helper('securedcheckout')->__('Hidden'),
            'opt' => Mage::helper('securedcheckout')->__('Optional'),
            'req' => Mage::helper('securedcheckout')->__('Required'),
        );
    }
}
