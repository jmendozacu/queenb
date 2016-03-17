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
 * @package     Magecheckout_CheckoutPromotion
 * @copyright   Copyright (c) 2014 Magecheckout (http://magecheckout.com/)
 * @license     http://magecheckout.com/license-agreement/
 */

/**
 * @category   Magecheckout
 * @package    Magecheckout_SecuredCheckout
 */
class Magecheckout_SecuredCheckout_Block_Adminhtml_Customblock_Shoppingcart_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('securedcheckout_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('securedcheckout')->__('Rule Information'));
	}

	/**
	 * prepare before render block to html
	 *
	 * @return Magecheckout_CheckoutPromotion_Block_Adminhtml_Checkoutpromotion_Edit_Tabs
	 */
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
			'label'   => Mage::helper('securedcheckout')->__('Rule Information'),
			'title'   => Mage::helper('securedcheckout')->__('Rule Information'),
			'content' => $this->getLayout()
				->createBlock('securedcheckout/adminhtml_customblock_shoppingcart_edit_tab_form')
				->toHtml(),
		));

		$this->addTab(
			'conditions_section',
			array(
				'label'   => $this->__('Conditions'),
				'title'   => $this->__('Conditions'),
				'content' => $this->getLayout()->createBlock('securedcheckout/adminhtml_customblock_shoppingcart_edit_tab_conditions')->toHtml(),
			)
		);

		$this->addTab(
			'actions_section',
			array(
				'label'   => $this->__('Actions'),
				'title'   => $this->__('Actions'),
				'content' => $this->getLayout()->createBlock('securedcheckout/adminhtml_customblock_shoppingcart_edit_tab_actions')->toHtml(),
			)
		);
		$this->_updateActiveTab();

		return parent::_beforeToHtml();
	}

	protected function _updateActiveTab()
	{
		$tabId = $this->getRequest()->getParam('tab');
		if ($tabId) {
			$tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
			if ($tabId) {
				$this->setActiveTab($tabId);
			}
		}
	}

}