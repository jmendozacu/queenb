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
 * @package     Magecheckout_SecuredCheckout
 * @copyright   Copyright (c) 2014 Magecheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * @category   Magecheckout
 * @package    Magecheckout_SecuredCheckout
 */
class Magecheckout_SecuredCheckout_Block_Adminhtml_Customblock_Shoppingcart_Edit_Tab_Actions extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('customblock_shoppingcart_data');
        $form  = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');

        $helper = Mage::helper('securedcheckout');

        $fieldset = $form->addFieldset('rule_met_fieldset', array('legend' => $helper->__('When this rule met')));

        $fieldset->addField('static_blocks_ids', 'multiselect', array(
            'label'  => Mage::helper('securedcheckout')->__('Show CMS Static Block'),
            'title'  => Mage::helper('securedcheckout')->__('Show CMS Static Block'),
            'name'   => 'static_blocks_ids',
            'values' => $this->_getStaticBlocks()
        ));

        $fieldset->addField('stop_rules', 'select', array(
            'label'    => Mage::helper('securedcheckout')->__('Stop further rules processing'),
            'title'    => Mage::helper('securedcheckout')->__('Stop further rules processing'),
            'name'     => 'stop_rules',
            'required' => true,
            'options'  => array(
                '1' => Mage::helper('securedcheckout')->__('Yes'),
                '0' => Mage::helper('securedcheckout')->__('No'),
            ),
        ));

        $fieldset = $form->addFieldset('show_securedcheckout_fieldset', array('legend' => $helper->__('Show this block on pages')));


        $fieldset->addField('is_securedcheckout', 'select', array(
            'label'    => Mage::helper('securedcheckout')->__('SecuredCheckout page'),
            'title'    => Mage::helper('securedcheckout')->__('SecuredCheckout page'),
            'name'     => 'is_securedcheckout',
            'required' => true,
            'options'  => array(
                '0' => Mage::helper('securedcheckout')->__('-- Please Select --'),
                '1' => Mage::helper('securedcheckout')->__('Top'),
                '2' => Mage::helper('securedcheckout')->__('Bottom'),
            ),
        ));

        $fieldset->addField('is_checkout_success', 'select', array(
            'label'    => Mage::helper('securedcheckout')->__('Checkout success page'),
            'title'    => Mage::helper('securedcheckout')->__('Checkout success page'),
            'name'     => 'is_checkout_success',
            'required' => true,
            'options'  => array(
                '0' => Mage::helper('securedcheckout')->__('-- Please Select --'),
                '1' => Mage::helper('securedcheckout')->__('Top'),
                '2' => Mage::helper('securedcheckout')->__('Bottom'),
            ),
        ));


        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function _getStaticBlocks()
    {
        $collection = Mage::getModel('cms/block')->getCollection();
        $options    = array();
        $options[]  = array('value' => '', 'label' => '-- None --');
        foreach ($collection as $block) {
            $options[] = array(
                'value' => $block->getIdentifier(),
                'label' => $block->getTitle()
            );
        }

        return $options;
    }

}