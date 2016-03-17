<?php

class Magecheckout_SecuredCheckout_Model_Attribute extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('securedcheckout/attribute');
    }

    /**
     * get all customer attribute used for onetepcheckout by postion
     *
     * @param null $store
     * @return Magecheckout_SecuredCheckout_Model_Mysql4_Attribute_Collection
     */
    public function getSortedFields()
    {
        $attributes = $this->getCollection()
            ->addFieldToFilter(
                'is_used_for_secured_checkout', array(
                    'neq' => '',
                )
            )
            ->addFieldToFilter(
                'is_billing', array(
                    'eq' => 1,
                )
            );
        $attributes->setOrder('position', Varien_Data_Collection::SORT_ORDER_ASC);

        return $attributes;
    }

    /**
     * @return Magecheckout_SecuredCheckout_Model_Mysql4_Attribute_Collection
     */
    public function getAvailableFields()
    {
        $attributes = $this->getCollection()
            ->addFieldToFilter(
                'is_used_for_secured_checkout', array(
                    'neq' => '',
                )
            )
            ->addFieldToFilter(
                'is_billing', array(
                    'eq' => 0,
                )
            );
        $attributes->setOrder('position', Varien_Data_Collection::SORT_ORDER_ASC);

        return $attributes;
    }

    public function getFieldColspanByCode($attribute_code)
    {
        $attributeField = $this->load($attribute_code, 'attribute_code');
        if ($attributeField && $attributeField->getId())
            return $attributeField->getColspan();

        return false;
    }

}