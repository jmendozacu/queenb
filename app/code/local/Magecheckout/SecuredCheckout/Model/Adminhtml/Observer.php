<?php

class Magecheckout_SecuredCheckout_Model_Adminhtml_Observer
{
    /**
     * @return $this
     */
    public function adminhtmlSystemConfigSave()
    {
        $section = Mage::app()->getRequest()->getParam('section');
        if ($section == 'securedcheckout') {
            $websiteCode   = Mage::app()->getRequest()->getParam('website');
            $storeCode     = Mage::app()->getRequest()->getParam('store');
            $css_generator = Mage::getSingleton('securedcheckout/generator_css');
            $css_generator->generateCss($websiteCode, $storeCode, 'design');
        }

        return $this;
    }
}