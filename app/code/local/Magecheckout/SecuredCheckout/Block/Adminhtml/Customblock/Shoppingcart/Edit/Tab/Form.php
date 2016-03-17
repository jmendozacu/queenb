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
class Magecheckout_SecuredCheckout_Block_Adminhtml_Customblock_Shoppingcart_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

	/**
	 * Prepare content for tab
	 *
	 * @return string
	 */
	public function getTabLabel()
	{
		return Mage::helper('securedcheckout')->__('Rule Information');
	}

	/**
	 * Prepare title for tab
	 *
	 * @return string
	 */
	public function getTabTitle()
	{
		return Mage::helper('securedcheckout')->__('Rule Information');
	}

	/**
	 * Returns status flag about this tab can be showed or not
	 *
	 * @return true
	 */
	public function canShowTab()
	{
		return true;
	}

	/**
	 * Returns status flag about this tab hidden or not
	 *
	 * @return true
	 */
	public function isHidden()
	{
		return false;
	}

    /**
     * prepare tab form's information
     *
     * @return Magecheckout_CheckoutPromotion_Block_Adminhtml_Checkoutpromotion_Edit_Tab_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('rule_');
		$model = Mage::registry('customblock_shoppingcart_data');
		$this->setForm($form);
        
        if (Mage::getSingleton('adminhtml/session')->getCustomblockShoppingcartData()) {
            $data = Mage::getSingleton('adminhtml/session')->getCustomblockShoppingcartData();
            Mage::getSingleton('adminhtml/session')->setCustomblockShoppingcartData(null);
        } elseif (Mage::registry('customblock_shoppingcart_data')) {
            $data = Mage::registry('customblock_shoppingcart_data')->getData();
        }

		$fieldset = $form->addFieldset('base_fieldset',
			array('legend' => Mage::helper('securedcheckout')->__('General Information'))
		);

		$fieldset->addField('name', 'text', array(
			'name' => 'name',
			'label' => Mage::helper('securedcheckout')->__('Rule Name'),
			'title' => Mage::helper('securedcheckout')->__('Rule Name'),
			'required' => true,
		));

		$fieldset->addField('description', 'textarea', array(
			'name' => 'description',
			'label' => Mage::helper('securedcheckout')->__('Description'),
			'title' => Mage::helper('securedcheckout')->__('Description'),
			'style' => 'height: 100px;',
		));

		$fieldset->addField('is_active', 'select', array(
			'label'     => Mage::helper('securedcheckout')->__('Status'),
			'title'     => Mage::helper('securedcheckout')->__('Status'),
			'name'      => 'is_active',
			'required' => true,
			'options'    => array(
				'1' => Mage::helper('securedcheckout')->__('Active'),
				'0' => Mage::helper('securedcheckout')->__('Inactive'),
			),
		));

		if (!$model->getId()) {
			$model->setData('is_active', '1');
		}

		if (Mage::app()->isSingleStoreMode()) {
			$websiteId = Mage::app()->getStore(true)->getWebsiteId();
			$fieldset->addField('website_ids', 'hidden', array(
				'name'     => 'website_ids[]',
				'value'    => $websiteId
			));
			$model->setWebsiteIds($websiteId);
		} else {
			$field = $fieldset->addField('website_ids', 'multiselect', array(
				'name'     => 'website_ids[]',
				'label'     => Mage::helper('securedcheckout')->__('Websites'),
				'title'     => Mage::helper('securedcheckout')->__('Websites'),
				'required' => true,
				'values'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteValuesForForm()
			));
			$renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
			$field->setRenderer($renderer);
		}

		$customerGroups = Mage::getResourceModel('customer/group_collection')->load()->toOptionArray();
		$found = false;

		foreach ($customerGroups as $group) {
			if ($group['value']==0) {
				$found = true;
			}
		}
		if (!$found) {
			array_unshift($customerGroups, array(
					'value' => 0,
					'label' => Mage::helper('securedcheckout')->__('NOT LOGGED IN'))
			);
		}

		$fieldset->addField('customer_group_ids', 'multiselect', array(
			'name'      => 'customer_group_ids[]',
			'label'     => Mage::helper('securedcheckout')->__('Customer Groups'),
			'title'     => Mage::helper('securedcheckout')->__('Customer Groups'),
			'required'  => true,
			'values'    => Mage::getResourceModel('customer/group_collection')->toOptionArray(),
		));


		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		$fieldset->addField('from_date', 'date', array(
			'name'   => 'from_date',
			'label'  => Mage::helper('securedcheckout')->__('From Date'),
			'title'  => Mage::helper('securedcheckout')->__('From Date'),
			'image'  => $this->getSkinUrl('images/grid-cal.gif'),
			'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
			'format'       => $dateFormatIso,
		));
		$fieldset->addField('to_date', 'date', array(
			'name'   => 'to_date',
			'label'  => Mage::helper('securedcheckout')->__('To Date'),
			'title'  => Mage::helper('securedcheckout')->__('To Date'),
			'image'  => $this->getSkinUrl('images/grid-cal.gif'),
			'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
			'format'       => $dateFormatIso,
		));

		$fieldset->addField('sort_order', 'text', array(
			'name' => 'sort_order',
			'label' => Mage::helper('securedcheckout')->__('Priority'),
		));
		$form->setValues($data);
        return parent::_prepareForm();
    }
}