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
 * SecuredCheckout Total Point Spend Block
 * You should write block extended from this block when you write plugin
 *
 * @category    Magecheckout
 * @package     Magecheckout_SecuredCheckout
 * @author      Magecheckout Developer
 */
class Magecheckout_SecuredCheckout_Block_Totals_Order_Giftwrap extends Mage_Core_Block_Template
{
    public function initTotals()
    {
        $totalsBlock = $this->getParentBlock();
        $order       = $totalsBlock->getOrder();
        if ($order && $order->getMcGiftwrapAmount() > 0.01) {
            $totalsBlock->addTotal(new Varien_Object(array(
                'code'        => 'mc_giftwrap_label',
                'label'       => $this->__('Gift wrap'),
                'value'       => $order->getMcGiftwrapAmount(),
                'is_formated' => false,
            )), 'subtotal');
        }
    }
}