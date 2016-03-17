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
class Magecheckout_SecuredCheckout_Adminhtml_StyleController extends Mage_Adminhtml_Controller_Action
{
    const XML_PATH_SHOW_NUMBER = 'securedcheckout/design_configuration/is_show_numbering';
    const XML_PATH_HEADING_STYLE = 'securedcheckout/design_configuration/heading_style';
    const XML_PATH_HEADING_BACKGROUND = 'securedcheckout/design_configuration/style_color';
    const XML_PATH_HEADING_COLOR = 'securedcheckout/design_configuration/style_heading_custom';
    const XML_PATH_HEADING_CUSTOM_COLOR = 'securedcheckout/design_configuration/style_custom';
    const XML_PATH_PLACE_ORDER_BUTTON = 'securedcheckout/design_configuration/place_order_color';

    public function importAction()
    {
        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = $this->getUrl("adminhtml/system_config/edit/section/securedcheckout/");
        }
        $styleType = $this->getRequest()->getParam('style_type');
        $website = Mage::app()->getRequest()->getParam('website');
        $store = Mage::app()->getRequest()->getParam('store');
        $this->_saveStyleConfig($styleType, $website, $store);
        $this->_generatorCss($website, $store);

        $this->getResponse()->setRedirect($refererUrl);
    }

    protected function _saveStyleConfig($styleType, $store, $website)
    {
        $scope = "default";
        $scope_id = 0;
        if (strlen($store)) {
            $store_id = Mage::getModel('core/store')->load($store)->getId();
            $scope = "stores";
            $scope_id = $store_id;
        } elseif (strlen($website)) {
            $website_id = Mage::getModel('core/website')->load($website)->getId();
            $scope = "websites";
            $scope_id = $website_id;
        }
        $config = Mage::getConfig();
        switch ($styleType) {
            case 'style01':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 1, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_1', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'black', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, '4D4D4D', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '4D4D4D', $scope, $scope_id);
                break;
            case 'style02':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 1, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_2', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'blue', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, '3399cc', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '3399cc', $scope, $scope_id);
                break;

            case 'style03':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'blue', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'FFFFFF', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '3399cc', $scope, $scope_id);
                break;

            case 'ultimo1':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_1', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '333333', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, '333333', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '00A9C7', $scope, $scope_id);
                break;

            case 'porto6':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '0083c1', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '0083c1', $scope, $scope_id);
                break;

            case 'porto1':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '3b3b3b', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '3b3b3b', $scope, $scope_id);
                break;

            case 'shopper':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, 'fe5252', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, 'fe5252', $scope, $scope_id);
                break;

            case 'fortis1':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, 'ff1c72', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, 'ff1c72', $scope, $scope_id);
                break;

            case 'blanco':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, 'ff4949', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, 'ff4949', $scope, $scope_id);
                break;


            case 'buyshop':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '9323b6', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '9323b6', $scope, $scope_id);
                break;

            case 'milano':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_1', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '333333', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, '333333', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '333333', $scope, $scope_id);
                break;

            case 'acumen':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_3', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '505050', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, 'ffffff', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, '0CF0CF', $scope, $scope_id);
                break;

            case 'blacknwhite':
                $config->saveConfig(self::XML_PATH_SHOW_NUMBER, 0, $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_STYLE, 'style_1', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_BACKGROUND, 'custom', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_CUSTOM_COLOR, '222', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_HEADING_COLOR, '222', $scope, $scope_id);
                $config->saveConfig(self::XML_PATH_PLACE_ORDER_BUTTON, 'f8ba75', $scope, $scope_id);
                break;


        }
        $config->cleanCache();
    }

    protected function _generatorCss($websiteCode, $storeCode)
    {
        $css_generator = Mage::getModel('securedcheckout/generator_css');
        $css_generator->generateCss($websiteCode, $storeCode, 'design');
    }

}