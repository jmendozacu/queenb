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
abstract class Magecheckout_SecuredCheckout_Block_Addition_Product_List_Related_Abstract extends Mage_Checkout_Block_Cart_Crosssell
{
    /**
     * @return bool
     */
    public function allowManageWishlist()
    {
        $isLoggedIn = $this->isLoggedIn();
        $isEnabled  = Mage::getStoreConfigFlag('wishlist/general/active');
        if (!$isLoggedIn || $isEnabled) {
            return false;
        }

        return true;
    }

    public function isLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

    /**
     * @return array|null
     */
    protected function _getWishlistIds()
    {
        if (is_null($this->_wishlistIds)) {
            $this->_wishlistIds = array();
            if ($this->isLoggedIn()) {
                $customer   = Mage::getSingleton('customer/session');
                $customerId = $customer->getCustomerId();
                if ($customer && $customerId) {
                    $wishlist = Mage::getModel('wishlist/wishlist')->loadByCustomer($customerId, true);
                    if ($wishlist && $wishlist->getId() && $wishlist->getCustomerId() === $customerId) {
                        $this->_wishlistIds = $this->_getWishlistCollection($wishlist)->getAllIds();
                    }
                }
            }
        }

        return $this->_wishlistIds;
    }

    public function canAddToWishlist($_item)
    {
        $isShow = in_array($_item->getId(), $this->_getWishlistIds());

        return $isShow;
    }

    /**
     * @return null
     */
    protected function _getCompareListIds()
    {
        if (is_null($this->_compareListIds)) {
            $collection = $this->_getCompareCollection();;
            if ($this->isLoggedIn()) {
                $collection->setData('customer_id', Mage::getSingleton('customer/session')->getCustomerId());
            } else {
                $collection->setData('visitor_id', Mage::getSingleton('log/visitor')->getId());
            }
            $this->_compareListIds = $collection->getAllIds();
        }

        return $this->_compareListIds;
    }

    /**
     * @param $_item
     * @return bool
     */
    public function canAddToCompareList($_item)
    {
        $isShow = in_array($_item->getId(), $this->_getCompareListIds());

        return $isShow;
    }

    /**
     * @param Mage_Wishlist_Model_Wishlist $wishlist
     * @return mixed
     */
    protected function _getWishlistCollection(Mage_Wishlist_Model_Wishlist $wishlist)
    {
        $collection = Mage::helper('securedcheckout')->getWishlistCollection($wishlist);

        return $collection;
    }

    /**
     * @return Mage_Catalog_Model_Resource_Collection_Abstract
     */
    protected function _getCompareCollection()
    {
        return Mage::getResourceModel('catalog/product_compare_item_collection')
            ->useProductItem(true)
            ->setStoreId(Mage::app()->getStore()->getId());
    }
}
