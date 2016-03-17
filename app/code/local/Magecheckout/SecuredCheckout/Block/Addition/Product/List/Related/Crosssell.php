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
class Magecheckout_SecuredCheckout_Block_Addition_Product_List_Related_Crosssell extends Magecheckout_SecuredCheckout_Block_Addition_Product_List_Related_Abstract
{

    /**
     * Items quantity will be capped to this value
     *
     * @var int
     */
    protected $_maxItemCount = 15;

    protected $_compareListIds = null;

    protected $_wishlistIds = null;

    public function getUrlToAddProductToWishlist()
    {
        $isSecure = Mage::app()->getStore()->isCurrentlySecure();

        return Mage::getUrl(
            'securedcheckout/checkout/addProductToWishlist',
            array(
                '_secure'  => $isSecure,
                'form_key' => Mage::getSingleton('core/session')->getFormKey(),
            )
        );
    }

    public function getUrlToAddProductToCompareList()
    {
        $isSecure = Mage::app()->getStore()->isCurrentlySecure();

        return Mage::getUrl(
            'securedcheckout/checkout/addProductToCompareList',
            array(
                '_secure'  => $isSecure,
                'form_key' => Mage::getSingleton('core/session')->getFormKey(),
            )
        );
    }
}
