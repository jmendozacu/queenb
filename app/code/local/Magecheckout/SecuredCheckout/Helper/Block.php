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
class Magecheckout_SecuredCheckout_Helper_Block extends Mage_Core_Helper_Data
{
    const CONFIG_ACTION_NODE = 'global/securedcheckout/actions';
    const FULL_HANDLE_NAME = 'securedcheckout_index_index';
    protected $_updateCheckoutLayout = null;


    public function toOptionArray()
    {
        /**
         * Set default
         */
        $optionArray = array(
            array(
                'label' => $this->__('--Select a CMS Static Blocks--'),
                'value' => null,
            )
        );

        if ($blockCollection = $this->getStaticBlockCollection()) {
            foreach ($blockCollection as $block) {
                $optionArray[] = array(
                    'value' => $block->getIdentifier(),
                    'label' => $block->getTitle(),
                );
            }
        }

        return $optionArray;
    }

    public function toArray()
    {
        if ($blockCollection = $this->getStaticBlockCollection()) {
            $array = array();
            foreach ($blockCollection as $block) {
                $array[$block->getIdentifier()] = $block->getIdentifier();
                $array[$block->getTitle()] = $block->getTitle();
            }
        }

        return $array;
    }

    /**
     * get action node in config.xml
     *
     * @return Mage_Core_Model_Config_Element
     */
    public function getActionNode()
    {
        $config = Mage::getConfig()->getNode(self::CONFIG_ACTION_NODE);
        if (!is_null($config))
            return $config;

        return null;
    }

    public function getStaticBlockCollection()
    {
        $collection = Mage::getResourceModel('cms/block_collection');

        return $collection;
    }

    public function getBlockMapping()
    {
        return (array)$this->getActionNode()->children();
    }

    /**
     * @param null $handle
     * @param null $layout
     */
    public function getActionBlocks($actionName = null, $handleName = null, $layout = null)
    {
        if (!$actionName)
            $actionName = Mage::app()->getRequest()->getActionName();
        if (!$handleName)
            $handleName = self::FULL_HANDLE_NAME;
        if (!$layout)
            $layout = Mage::app()->getLayout();
        $this->_initUpdateLayout($layout, $handleName);
        $blockNode = (array)$this->getActionNode()->$actionName;
        $blocks = array();
        foreach ($blockNode as $action => $blockName) {
            $block = $layout->getBlock($blockName);
            if ($block) {
                $blocks[$action] = $block->toHtml();
            }
        }

        return $blocks;
    }

    /**
     * Init layout from handel name
     *
     * @param $layout
     * @param $handleName
     */
    protected function _initUpdateLayout($layout, $handleName)
    {
        $update = $layout->getUpdate();
        $update->addHandle('default');
        $update->addHandle('STORE_' . Mage::app()->getStore()->getCode());
        $package = Mage::getSingleton('core/design_package');
        $update->addHandle(
            'THEME_' . $package->getArea() . '_' . $package->getPackageName() . '_' . $package->getTheme('layout')
        );
        $update->addHandle(strtolower($handleName));
        Mage::dispatchEvent(
            'controller_action_layout_load_before',
            array('action' => Mage::app()->getFrontController()->getAction(), 'layout' => $layout)
        );
        $update->load();
        Mage::dispatchEvent(
            'controller_action_layout_load_after',
            array('action' => Mage::app()->getFrontController()->getAction(), 'layout' => $layout)
        );
        $this->_initLayoutMessages('checkout/session', $layout);
        $layout->generateXml();
        $layout->generateBlocks();

    }

    /**
     * Initializing layout messages by message storage(s), loading and adding messages to layout messages block
     *
     * @param string|array $messagesStorage
     * @return Mage_Core_Controller_Varien_Action
     */
    protected function _initLayoutMessages($messagesStorage, $layout)
    {
        if (!is_array($messagesStorage)) {
            $messagesStorage = array($messagesStorage);
        }
        foreach ($messagesStorage as $storageName) {
            $storage = Mage::getSingleton($storageName);
            if ($storage) {
                $block = $layout->getMessagesBlock();
                $block->addMessages($storage->getMessages(true));
                $block->setEscapeMessageFlag($storage->getEscapeMessages(true));
                $block->addStorageType($storageName);
            } else {
                Mage::throwException(
                    Mage::helper('core')->__('Invalid messages storage "%s" for layout messages initialization', (string)$storageName)
                );
            }
        }

        return $this;
    }
}