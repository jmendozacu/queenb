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
class Morningtime_Migs_Model_Source_Pendingpayment extends Mage_Adminhtml_Model_System_Config_Source_Order_Status
{
    protected $_stateStatuses = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
}