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
 * @category   Magecheckout
 * @package    Magecheckout_SecuredCheckout
 * @version    3.0.0
 * @copyright   Copyright (c) 2014 Magecheckout (http://www.magecheckout.com/)
 * @license     http://www.magecheckout.com/license-agreement.html
 */
class
Magecheckout_SecuredCheckout_Block_Container extends Mage_Checkout_Block_Onepage_Abstract
{
    protected $_helperData;
    protected $_helperConfig;
    protected $_isSecure;
    protected $_blockSection = array(
        'shipping_method'     => '#one-step-checkout-shipping-method .shipping-methods',
        'payment_method'      => '#one-step-checkout-payment-method .one-step-checkout-payment-methods',
        'review_cart'         => '.one-step-checkout-order-review-cart',
        'review_coupon'       => '#one-step-checkout-review-coupon',
        'custom_block_top'    => '#one-step-checkout-custom-block-top',
        'custom_block_bottom' => '#one-step-checkout-custom-block-bottom',
        'related'             => '#one-step-checkout-related',
        'cart_sidebar'        => '.header-minicart'
    );

    public function __construct()
    {
        parent::__construct();
        $this->_helperData   = Mage::helper('securedcheckout');
        $this->_helperConfig = Mage::helper('securedcheckout/config');
        $this->_isSecure     = Mage::app()->getStore()->isCurrentlySecure();
    }

    /**
     * get helper config
     *
     * @return
     */
    public function getHelperConfig()
    {
        return $this->_helperConfig;
    }

    public function getHelperData()
    {
        return $this->_helperData;
    }

    /**
     * get current url is http or https
     *
     * @return bool
     */
    public function isSecure()
    {
        return $this->_isSecure;
    }

    public function getBlockMapping()
    {
        $blocks       = array();
        $blockMapping = Mage::helper('securedcheckout/block')->getBlockMapping();
        foreach ($blockMapping as $action => $blockName) {
            $blocks[$action] = array_keys((array)$blockName);
        }

        return Mage::helper('core')->jsonEncode($blocks);
    }

    public function getBlockSection()
    {
        $blocks = new Varien_Object();
        $blocks->setBlocks($this->_blockSection);
        Mage::dispatchEvent('one_step_checkout_prepare_block_section_after', array(
            'blocks' => $blocks
        ));

        return Mage::helper('core')->jsonEncode($blocks->getBlocks());
    }

    public function getNumbering($increment = true)
    {
        return Mage::helper('securedcheckout')->getNumbering($increment);
    }


    public function getGrandTotal()
    {
        return Mage::helper('securedcheckout')->getGrandTotal($this->getQuote());
    }

    public function showGrandTotal()
    {
        return $this->getHelperConfig()->showGrandTotal();
    }

    public function getPlaceOrderUrl()
    {
        return Mage::getUrl('securedcheckout/checkout/saveOrder', array('_secure' => $this->isSecure()));
    }

    public function getCheckoutSuccessUrl()
    {
        return Mage::getUrl('checkout/onepage/success', array('_secure' => $this->isSecure()));
    }

    /**
     * Checkout title config
     *
     * @return string
     */
    public function getCheckoutTitle()
    {
        return $this->escapeHtml($this->getHelperConfig()->getCheckoutTitle());
    }

    /**
     * Checkout description config
     *
     * @return mixed
     */
    public function getCheckoutDescription()
    {
        return $this->getHelperConfig()->getCheckoutDescription();
    }

    public function allowShipToDifferent()
    {
        return $this->getHelperConfig()->allowShipToDifferent();
    }

    /**
     * @return string
     */
    public function getChangeAddressUrl()
    {

        return Mage::getUrl('securedcheckout/checkout/saveAddressTrigger', array('_secure' => $this->isSecure()));
    }

    /**
     * @return string
     */
    public function getSaveFormUrl()
    {
        return Mage::getUrl('securedcheckout/checkout/saveForm', array('_secure' => $this->isSecure()));
    }

    /**
     * get save shipping method url
     *
     * @return string
     */
    public function getSaveShippingMethodUrl()
    {
        return Mage::getUrl('securedcheckout/checkout/saveShippingMethod', array('_secure' => $this->isSecure()));
    }

    /**
     * @return string
     */
    public function getSavePaymentUrl()
    {
        return Mage::getUrl('securedcheckout/checkout/savePayment', array('_secure' => $this->isSecure()));
    }

    public function getCouponCode()
    {
        return $this->getQuote()->getCouponCode();
    }

    public function getApplyCouponAjaxUrl()
    {
        return Mage::getUrl('securedcheckout/checkout/saveCoupon', array('_secure' => $this->isSecure()));
    }

    public function getCancelCouponAjaxUrl()
    {
        return Mage::getUrl('securedcheckout/checkout/cancelCoupon', array('_secure' => $this->isSecure()));
    }

    public function getFormData()
    {
        return Mage::getSingleton('checkout/session')->getData('securedcheckout_form_values');
    }

    public function getCommentsData()
    {
        $data = Mage::getSingleton('checkout/session')->getData('securedcheckout_form_values');
        if (isset($data['comments'])) {
            return $data['comments'];
        }

        return '';
    }

    /**
     * get Customer Name
     *
     * @return string
     */
    public function getUsername()
    {
        $username = Mage::getSingleton('customer/session')->getUsername(true);

        return $this->escapeHtml($username);
    }

    /**
     *
     */
    public function getActionPattern()
    {
        $actionPattern = '/securedcheckout\/checkout\/([^\/]+)\//';

        return $actionPattern;
    }


    public function isEnabledMorphEffect()
    {
        return $this->getHelperConfig()->isEnabledMorphEffect();
    }
}