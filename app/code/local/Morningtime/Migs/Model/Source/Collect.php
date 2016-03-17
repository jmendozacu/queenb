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

class Morningtime_Migs_Model_Source_Collect
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => Mage::helper('migs')->__('No Card Details')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('migs')->__('Only Card Type')
            ),
            array(
                'value' => 2,
                'label' => Mage::helper('migs')->__('All Card Details')
            ),
            array(
                'value' => 3,
                'label' => Mage::helper('migs')->__('All Card Details + Card Secure Code (CSC)')
            ),
        );
    }

}
