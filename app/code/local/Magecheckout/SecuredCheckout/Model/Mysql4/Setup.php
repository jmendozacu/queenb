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
 * @package     Magecheckout_SecuredCheckout
 * @copyright   Copyright (c) 2014 MageCheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * SecuredCheckout Resource Model
 *
 * @category    MageCheckout
 * @package     Magecheckout_SecuredCheckout
 * @author      MageCheckout Developer
 */
class Magecheckout_SecuredCheckout_Model_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{
    public function addCustomerFieldToSecuredCheckout($installer)
    {
        // add field that indicates that attribute is used for customer segments to attribute properties
        $installer->getConnection()
            ->addColumn($installer->getTable('customer/eav_attribute'), 'is_used_for_secured_checkout', 'varchar(10) default NULL');
        // use specific required attributes for securedcheckout
        $reqAttributesOfEntities = array(
            'customer'         => array('email', 'firstname', 'lastname'),
            'customer_address' => array('street', 'city', 'region_id', 'postcode', 'country_id'),
        );

        foreach ($reqAttributesOfEntities as $entityTypeId => $attributes) {
            foreach ($attributes as $attributeCode) {
                $installer->updateAttribute($entityTypeId, $attributeCode, 'is_used_for_secured_checkout', 'req');
            }
        }
        // use specific optional attributes for securedcheckout
        $optAttributesOfEntities = array(
            'customer_address' => array('telephone', 'company'),
        );

        foreach ($optAttributesOfEntities as $entityTypeId => $attributes) {
            foreach ($attributes as $attributeCode) {
                $installer->updateAttribute($entityTypeId, $attributeCode, 'is_used_for_secured_checkout', 'opt');
            }
        }
    }

    /**
     * Insert Magecheckout Static block
     */
    public function  insertStaticBlocks()
    {
        Mage::getSingleton('securedcheckout/generator_block')->importStaticBlocks('cms/block', 'blocks', true);
    }

    /**
     * Insert Default fields for securedcheckout
     */
    public function insertFieldsPosition()
    {
        Mage::getResourceModel('securedcheckout/attribute')->initFields();
    }
}
