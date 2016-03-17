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

class Morningtime_Migs_MerchantController extends Morningtime_Migs_Controller_Common
{
    /**
     * Return payment API model
     *
     * @return Morningtime_Migs_Model_Api_Merchant
     */
    protected function getApi()
    {
        return Mage::getSingleton('migs/api_merchant');
    }

    /**
     * Placement of DO (curlPost)
     */
    public function placementAction()
    {
        $this->saveCheckoutSession();
        $order = $this->getLastRealOrder();
        $storeId = $order->getStoreId();

        // Prepare curl
        $formFields = $this->getApi()->getFormFields($order);
        $postUrl = $this->getApi()->getConfigData('vpc_url', $storeId);
        $postData = http_build_query($formFields, '', '&');

        // Process response
        $response = $this->getApi()->curlPost($postUrl, $postData);
        parse_str($response, $output);

        $redirectUrl = 'checkout/cart';
        if ($output) {
            $cardType = isset($output['vpc_Card']) ? $output['vpc_Card'] : '';
            $receiptNo = isset($output['vpc_ReceiptNo']) ? $output['vpc_ReceiptNo'] : '';
            $acqResponseCode = isset($output['vpc_AcqResponseCode']) ? $output['vpc_AcqResponseCode'] : '';
            $authId = isset($output['vpc_AuthorizeId']) ? $output['vpc_AuthorizeId'] : '';
            $txnCode = isset($output['vpc_TxnResponseCode']) ? $output['vpc_TxnResponseCode'] : '';
            $txnNr = isset($output['vpc_TransactionNo']) ? $output['vpc_TransactionNo'] : 1;

            // Build note
            $note = $output['vpc_Message'];
            $note .= '<br />' . Mage::helper('migs')->__('Card Type') . ': ' . $cardType;
            $note .= '<br />' . Mage::helper('migs')->__('Receipt No') . ': ' . $receiptNo;
            $note .= '<br />' . Mage::helper('migs')->__('Acquirer Response Code') . ': ' . $acqResponseCode;
            $note .= '<br />' . Mage::helper('migs')->__('Bank Authorization ID') . ': ' . $authId;
            $note .= '<br />' . Mage::helper('migs')->__('Transaction Response Code') . ': ' . $txnCode;

            // Process order
            switch ($txnCode) {
                case 0 :
                case '00' :
                    if ($this->getApi()->getConfigData('capture_mode')) {
                        $this->getProcess()->success($order, $note, $txnNr, 1, true);
                    }
                    else {
                        $this->getProcess()->pending($order, $note, $txnNr, 1, true);
                    }
                    $redirectUrl = 'checkout/onepage/success';
                    break;

                default :
                    $this->getProcess()->cancel($order, $note, $txnNr, 1, true);
                    $this->getProcess()->repeat();
            }
        }
        elseif (isset($output['vpc_Message'])) {
            $this->getCheckout()->addError(Mage::helper('migs')->__('MIGS Error: %s', $params['vpc_Message']));
        }

        // Debug (after directFields(), to avoid resetting CcNumber & CcCid)
        if ($this->getApi()->getConfigData('debug_flag')) {
            $url = $this->getRequest()->getPathInfo();
            $data = print_r($this->getApi()->getDirectFields($order), true);
            Mage::getModel('migs/api_debug')->setDir('out')->setUrl($url)->setData('data', $data)->save();
        }

        // Redirect
        $this->_redirect($redirectUrl, array('_secure' => true));
    }

}
