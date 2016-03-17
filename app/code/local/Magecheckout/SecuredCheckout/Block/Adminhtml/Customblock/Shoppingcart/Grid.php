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
class Magecheckout_SecuredCheckout_Block_Adminhtml_Customblock_Shoppingcart_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('securedcheckoutGrid');
        $this->setDefaultSort('securedcheckout_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * prepare collection for block to display
     *
     * @return Magecheckout_CheckoutPromotion_Block_Adminhtml_Checkoutpromotion_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('securedcheckout/customblock_shoppingcart')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * prepare columns for this grid
     *
     * @return Magecheckout_CheckoutPromotion_Block_Adminhtml_Checkoutpromotion_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('rule_id', array(
            'header' => Mage::helper('salesrule')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'rule_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('salesrule')->__('Rule Name'),
            'align'  => 'left',
            'index'  => 'name',
        ));

        $this->addColumn('from_date', array(
            'header' => Mage::helper('salesrule')->__('Date Start'),
            'align'  => 'left',
            'width'  => '120px',
            'type'   => 'date',
            'index'  => 'from_date',
        ));

        $this->addColumn('to_date', array(
            'header'  => Mage::helper('salesrule')->__('Date Expire'),
            'align'   => 'left',
            'width'   => '120px',
            'type'    => 'date',
            'default' => '--',
            'index'   => 'to_date',
        ));

        $this->addColumn('is_active', array(
            'header'  => Mage::helper('salesrule')->__('Status'),
            'align'   => 'left',
            'width'   => '80px',
            'index'   => 'is_active',
            'type'    => 'options',
            'options' => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('rule_website', array(
                'header'   => Mage::helper('salesrule')->__('Website'),
                'align'    => 'left',
                'index'    => 'website_ids',
                'type'     => 'options',
                'sortable' => false,
                'options'  => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(),
                'width'    => 200,
            ));
        }

        $this->addColumn('sort_order', array(
            'header' => Mage::helper('salesrule')->__('Priority'),
            'align'  => 'right',
            'index'  => 'sort_order',
            'width'  => 100,
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('securedcheckout')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('securedcheckout')->__('Edit'),
                        'url'     => array('base' => '*/*/edit'),
                        'field'   => 'id'
                    )),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

        $this->addExportType('*/*/exportCsv', Mage::helper('securedcheckout')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('securedcheckout')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action for this grid
     *
     * @return Magecheckout_CheckoutPromotion_Block_Adminhtml_Checkoutpromotion_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('securedcheckout_id');
        $this->getMassactionBlock()->setFormFieldName('securedcheckout');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => Mage::helper('securedcheckout')->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('securedcheckout')->__('Are you sure?')
        ));

        $status = Mage::getSingleton('securedcheckout/status')->getOptionArray();
//        array_unshift($status, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'      => Mage::helper('securedcheckout')->__('Change status'),
            'url'        => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name'   => 'status',
                    'type'   => 'select',
                    'class'  => 'required-entry',
                    'label'  => Mage::helper('securedcheckout')->__('Status'),
                    'values' => $status
                ))
        ));

        return $this;
    }

    /**
     * get url for each row in grid
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}