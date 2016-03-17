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
class Magecheckout_SecuredCheckout_Model_Observer
{
    /**
     * Default Dispatch checkout event
     *
     * @param $observer
     * Ref: Mage_Checkout module
     */
    public function controllerActionPredispatchCheckout($observer)
    {
        $controllerInstance = $observer->getControllerAction();
        if (
            $controllerInstance instanceof Mage_Checkout_OnepageController &&
            $controllerInstance->getRequest()->getActionName() !== 'success' &&
            $controllerInstance->getRequest()->getActionName() !== 'failure' &&
            $controllerInstance->getRequest()->getActionName() !== 'saveOrder' &&
            Mage::helper('securedcheckout/config')->isEnabled()
        ) {
            $controllerInstance->getResponse()->setRedirect(
                Mage::getUrl('securedcheckout', array('_secure' => true))
            );
            $controllerInstance->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
        }
    }

    public function paypalPrepareLineItems($observer)
    {
        if ($paypalCart = $observer->getPaypalCart()) {
            $salesEntity        = $paypalCart->getSalesEntity();
            $giftWrapBaseAmount = $salesEntity->getMcGiftwrapBaseAmount();
            if ($giftWrapBaseAmount > 0.0001) {
                $paypalCart->updateTotal(
                    Mage_Paypal_Model_Cart::TOTAL_SUBTOTAL,
                    (float)$giftWrapBaseAmount,
                    Mage::helper('securedcheckout')->__('Gift wrap')
                );
            }
        }

        return $this;
    }

    /**
     * Submit after
     *
     * @param $observer
     * @return $this
     */
    public function checkoutSubmitAllAfter($observer)
    {
        $event = $observer->getEvent();
        if (!$event)
            return $this;
        $order     = $event->getOrder();
        $orderData = Mage::getSingleton('checkout/session')->getData('securedcheckout_order_data');

        if (!is_array($orderData))
            $orderData = array();

        if (!$order || !$order->getId())
            return $this;


        $this->addSurvey($orderData, $order);
        $this->_isSubscribeNewsletter($orderData);
        $this->_clear();

        return $this;
    }


    public function checkoutTypeOnepageSaveOrderAfter($observer)
    {
        $event = $observer->getEvent();
        if (!$event)
            return $this;
        $order = $event->getOrder();
        if (!$order || !$order->getId())
            return $this;
        $orderData = Mage::getSingleton('checkout/session')->getData('securedcheckout_order_data');
        if (!is_array($orderData)) {
            $orderData = array();
        }
        // add customer comment
        if (array_key_exists('comments', $orderData) && ($orderData['comments']) != '') {
            $comment = $orderData['comments'];
            $order->addStatusHistoryComment(Mage::helper('securedcheckout')->__('%s: %s', $order->getCustomerName(), $comment))
                ->setIsVisibleOnFront(true)
                ->save();
        }
        // add delivery time
        if (array_key_exists('delivery', $orderData) && !empty($orderData['delivery'])) {
            $delivery_data = $orderData['delivery'];
            $delivery      = Mage::getModel('securedcheckout/delivery');
            $delivery
                ->setDeliveryTimeDate($delivery_data['date'] . ' ' . $delivery_data['time'])
                ->setOrderId($order->getId())
                ->save();
        }

        return $this;

    }

    /**
     * Compatibility with Paypal Hosted Pro
     *
     * @param $observer
     */
    public function securedCheckoutSaveOrder($observer)
    {
        $paypal  = Mage::getModel('paypal/observer');
        $isExist = method_exists($paypal, 'setResponseAfterSaveOrder');
        if (!$isExist) {
            return $this;
        }
        $action    = $observer->getEvent()->getControllerAction();
        $result    = Mage::helper('core')->jsonDecode($action->getResponse()->getBody(), 1);
        $isSuccess = $result['success'];
        if ($isSuccess) {
            $paypal->setResponseAfterSaveOrder($observer);
            $result                  = Mage::helper('core')->jsonDecode($action->getResponse()->getBody(), 1);
            $result['is_hosted_pro'] = true;
            $action->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }

        return $this;
    }


    /**
     * @param $observer
     */
    public function compatibleExtensions($observer)
    {
        $updateRoot = $observer->getUpdates();
        $removeList = array();
        foreach ($updateRoot->children() as $key => $node) {
            if ($node->file) {
                if (strpos($key, 'securedcheckout') !== false) {
                    $module    = $node->getAttribute('module');
                    $isEnabled = Mage::helper('core')->isModuleOutputEnabled($module);
                    if ($module && !$isEnabled) {
                        $removeList[] = $key;
                    }
                }
            }
        }
        $this->_removeNode($removeList, $updateRoot);
    }

    /**
     * @param $removeList
     * @param $note
     */
    protected function _removeNode($removeList, $note)
    {
        foreach ($removeList as $nodeKey) {
            unset($note->$nodeKey);
        }
    }

    /**
     * @param $observer
     * @return $this
     */
    public function coreLayoutBlockCreateAfter($observer)
    {
        $block = $observer->getBlock();

        if (Mage::app()->getRequest()->getControllerModule() == 'Magecheckout_SecuredCheckout') {
            if ($block instanceof Mage_Authorizenet_Block_Directpost_Form) {
                $block->setTemplate('magecheckout/securedcheckout/checkout/payment/authorizenet/directpost.phtml');
            }
        }

        return $this;

    }

    public function addSurvey($data, $order)
    {
        if (array_key_exists('securedcheckout_survey_answer', $data) && $data['securedcheckout_survey_answer']) {
            $pollId = intval($data['securedcheckout_survey_question']);
            $poll   = Mage::getModel('poll/poll')->load($pollId);
            /** @var $poll Mage_Poll_Model_Poll */

            /**
             * Check poll data
             */
            if ($poll->getId() && !$poll->getClosed() && !$poll->isVoted()) {

                $answerId = intval($data['securedcheckout_survey_answer']);
                $answer   = Mage::getModel('poll/poll_answer')->getCollection()
                    ->addPollFilter($pollId)
                    ->addFieldToFilter('answer_id', $answerId)
                    ->getFirstItem();
                /*Save data to Database*/
                $survey = Mage::getModel('securedcheckout/survey');
                $survey
                    ->setQuestion($poll->getPollTitle())
                    ->setAnswer($answer->getAnswerTitle())
                    ->setOrderId($order->getId())
                    ->save();
                $vote = Mage::getModel('poll/poll_vote')
                    ->setPollAnswerId($answerId)
                    ->setIpAddress(Mage::helper('core/http')->getRemoteAddr(true))
                    ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
                $poll->addVote($vote);
                Mage::dispatchEvent(
                    'poll_vote_add',
                    array(
                        'poll' => $poll,
                        'vote' => $vote
                    )
                );
            }
        }

    }

    protected function _clear()
    {
        Mage::getSingleton('checkout/session')->setData('securedcheckout_form_values', array());
        Mage::getSingleton('checkout/session')->setData('securedcheckout_order_data', array());
        Mage::getSingleton('checkout/session')->setData('is_used_giftwrap', '');
        Mage::getSingleton('checkout/session')->setData('same_as_billing', '');
    }


    protected function _isSubscribeNewsletter($orderData)
    {
        if (array_key_exists('is_subscribed', $orderData) && $orderData['is_subscribed']) {
            $customer         = Mage::getSingleton('customer/session')->getCustomer();
            $data             = array();
            $data['store_id'] = Mage::app()->getStore()->getId();
            if (!$customer || $customer->getId()) {
                $billing            = $orderData['billing'];
                $data['first_name'] = $billing['firstname'];
                $data['email']      = $billing['email'];
                $data['last_name']  = $billing['last_name'];
            } else {
                $data['customer_id'] = $customer->getId();
                $data['first_name']  = $customer->getFirstname();
                $data['email']       = $customer->getEmail();
                $data['last_name']   = $customer->getLastname();
            }
            Mage::helper('securedcheckout/checkout_newsletter')->subscribeCustomer($data);
        }
    }

}