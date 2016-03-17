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
 * @category     Magecheckout
 * @package     Magecheckout_CheckoutPromotion
 * @copyright     Copyright (c) 2014 Magecheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * @category   Magecheckout
 * @package    Magecheckout_SecuredCheckout
 */
class Magecheckout_SecuredCheckout_Block_Adminhtml_Customblock_Shoppingcart_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare form's information for block
     *
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array(
                'id'    => $this->getRequest()->getParam('id'),
            )),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}