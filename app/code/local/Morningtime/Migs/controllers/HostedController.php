<?php
/**
 * Morningtime Extensions
 * http://shop.morningtime.com
 *
 * @extension   MasterCard Internet Gateway Service (MIGS) - Virtual Payment Client
 * @type        Payment method
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category    Magento Commerce
 * @package     Morningtime_Migs
 * @copyright   Copyright (c) 2011-2012 Morningtime Digital Media (http://www.morningtime.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Morningtime_Migs_HostedController extends Morningtime_Migs_Controller_Common
{
    /**
     * Return payment API model
     *
     * @return Morningtime_Migs_Model_Api_Hosted
     */
    protected function getApi()
    {
        return Mage::getSingleton('migs/api_hosted');
    }

    /**a
     * Placement Action
     */
    public function placementAction()
    {
        $this->saveCheckoutSession();
        $order = $this->getLastRealOrder();
        $storeId = $order->getStoreId();

        // Prepare query string for GET request
        $gateway = $this->getApi()->getConfigData('vpc_url', $storeId);
        $formFields = $this->getApi()->getFormFields($order);
        $queryString = http_build_query($formFields, '', '&');

        // Debug after getFormFields() to avoid wiping Cc Details
        if ($this->getApi()->getConfigData('debug_flag')) {
            $url = $this->getRequest()->getPathInfo();
            $data = print_r($this->getApi()->getFormFields($order), true);
            Mage::getModel('migs/api_debug')->setDir('out')->setUrl($url)->setData('data', $data)->save();
        }

        // Redirect to external page with GET fields
        $this->_redirectUrl($gateway . '?' . $queryString);
    }

    /**
     * Return action for 3-Party Mode
     * We need to update the order here
     */
    public function returnAction()
    {
        $params = $this->getRequest()->getParams();
        $this->saveDebugIn($params);

        $redirectUrl = 'checkout/cart';
        if (isset($params['vpc_SecureHash']) && $this->validateReceipt($params)) {
            if (isset($params['vpc_MerchTxnRef'])) {
                $order = Mage::getModel('sales/order')->loadByIncrementId($params['vpc_MerchTxnRef']);
                if ($order->getId()) {
                    $amount = $params['vpc_Amount'];
                    $message = $params['vpc_Message'];
                    $cardType = $params['vpc_Card'];
                    $receiptNo = $params['vpc_ReceiptNo'];
                    $authorizeID = $params['vpc_AuthorizeId'];
                    $merchTxnRef = $params['vpc_MerchTxnRef'];
                    $transactionNo = $params['vpc_TransactionNo'];
                    $acqResponseCode = $params['vpc_AcqResponseCode'];
                    $txnResponseCode = $params['vpc_TxnResponseCode'];

                    // Build note
                    $note = $message;
                    $note .= '<br />' . Mage::helper('migs')->__('Card Type') . ': ' . $cardType;
                    $note .= '<br />' . Mage::helper('migs')->__('Receipt No') . ': ' . $receiptNo;
                    $note .= '<br />' . Mage::helper('migs')->__('Acquirer Response Code') . ': ' . $acqResponseCode;
                    $note .= '<br />' . Mage::helper('migs')->__('Bank Authorization ID') . ': ' . $authorizeID;
                    $note .= '<br />' . Mage::helper('migs')->__('Transaction Response Code') . ': ' . $txnResponseCode;

                    // Process order
                    switch ($txnResponseCode) {
                        case 0 :
                        case '00' :
                            if ($this->getApi()->getConfigData('capture_mode')) {
                                $this->getProcess()->success($order, $note, $transactionNo, 1, true);
                            }
                            else {
                                $this->getProcess()->pending($order, $note, $transactionNo, 1, true);
                            }
                            $redirectUrl = 'checkout/onepage/success';
                            break;

                        default :
                            $this->getProcess()->cancel($order, $note, $transactionNo, 1, true);
                            $this->getProcess()->repeat();
                    }
                }
            }
        }
        elseif (isset($params['vpc_Message'])) {
            $this->getCheckout()->addError(Mage::helper('migs')->__('MIGS Error: %s', $params['vpc_Message']));
        }

        // Redirect
        $this->_redirect($redirectUrl, array('_secure' => true));
    }

    /**
     * Validate receipt
     */
    public function validateReceipt($params)
    {
        $storeId = Mage::app()->getStore()->getId();
        $md5HashData = $this->getApi()->getConfigData('secure_secret', $storeId);

        ksort($params);
        foreach ($params as $key => $value) {
            if ($key != 'vpc_SecureHash' && strlen($value) > 0) {
                $md5HashData .= $value;
            }
        }

        return strtoupper($params['vpc_SecureHash']) == strtoupper(md5($md5HashData));
    }

}
