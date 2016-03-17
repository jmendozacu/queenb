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
class Magecheckout_SecuredCheckout_Model_System_Config_Source_Poll_Questions
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array(
            array(
                'value'=> '',
                'label' => '-- Select a Magento Poll --'
            )
        );

        $polls   = Mage::getModel('poll/poll')->getCollection();
        foreach ($polls as $poll) {
            $options[] = array(
                'value' => $poll->getId(),
                'label' => $poll->getPollTitle()
            );
        }

        return $options;

    }
}
