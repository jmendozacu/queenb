<?php
/**
 * MageCheckout
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageCheckout.com license that is
 * available through the world-wide-web at this URL:
 * http://magecheckout.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    MageCheckout
 * @package     MageCheckout_CheckoutPromotion
 * @copyright   Copyright (c) 2014 MageCheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * SecuredCheckout Model
 *
 * @category    MageCheckout
 * @package     Magecheckout_SecuredCheckout
 * @author      MageCheckout Developer
 */
class Magecheckout_SecuredCheckout_Model_Customblock_Shoppingcart extends Mage_Rule_Model_Rule
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('securedcheckout/customblock_shoppingcart');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        if ($this->hasWebsiteIds()) {
            $websiteIds = $this->getWebsiteIds();
            if (is_array($websiteIds) && !empty($websiteIds)) {
                $this->setWebsiteIds(implode(',', $websiteIds));
            }
        }
        if ($this->hasCustomerGroupIds()) {
            $groupIds = $this->getCustomerGroupIds();
            if (is_array($groupIds) && !empty($groupIds)) {
                $this->setCustomerGroupIds(implode(',', $groupIds));
            }
        }

        if ($this->hasStaticBlocksIds()) {
            $blockIds = $this->getStaticBlocksIds();
            if (is_array($blockIds) && !empty($blockIds)) {
                $this->setStaticBlocksIds(implode(',', $blockIds));
            }
        }


        return $this;
    }

    public function loadPost(array $rule)
    {
        $arr = $this->_convertFlatToRecursive($rule);
        if (isset($arr['conditions'])) {
            $this->getConditions()->loadArray($arr['conditions'][1]);
        }

        return $this;
    }


    public function getConditionsInstance()
    {
        return Mage::getModel('securedcheckout/rule_condition_combine');
    }


    /**
     * Fix error when load and save with collection
     */
    protected function _afterLoad()
    {
        $this->setConditions(null);

        return parent::_afterLoad();
    }

    public function checkRule($quote)
    {
        $this->afterLoad();

        return $this->validate($quote);
    }


}