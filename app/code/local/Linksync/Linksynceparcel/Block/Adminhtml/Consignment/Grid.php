<?php
 
class Linksync_Linksynceparcel_Block_Adminhtml_Consignment_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('order_consignment');
        $this->setDefaultSort('increment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function  getSearchButtonHtml()
    {
        return parent::getSearchButtonHtml();
    }
 
    protected function _prepareCollection()
    {
		$status_condition = 'main_table.status = "processing" OR main_table.status = "pending" OR';
		$display_choosen_status = (int)Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/display_choosen_status');
		if($display_choosen_status == 1)
		{
			$chosen_statuses = Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/chosen_statuses');
			if(!empty($chosen_statuses))
			{
				$chosen_statuses = explode(',',$chosen_statuses);
				if(count($chosen_statuses) > 0)
				{
					$status_condition = '';
					foreach($chosen_statuses as $chosen_status)
					{
						if(!empty($chosen_status))
							$status_condition .= 'main_table.status="'.$chosen_status.'" OR ';
					}
				}
			}
		}
		
		if(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/apply_to_all') && Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/default_chargecode') != '')
		{
			$collection = Mage::getModel('linksynceparcel/consignmentui')->getCollection();
			$collection
				->getSelect()
				->joinLeft(array('order_address' => Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address')),
						'main_table.shipping_address_id = order_address.entity_id')
				->reset(Zend_Db_Select::COLUMNS)
				->columns(new Zend_Db_Expr("CONCAT(`order_address`.`firstname`, ' ',`order_address`.`lastname`) AS fullname"))
				->columns('CONCAT(main_table.entity_id, "_",IFNULL(c.consignment_number,0)) as order_consignment')
				->columns('main_table.customer_firstname')
				->columns('main_table.customer_lastname')
				->columns('main_table.is_address_valid')
				->columns('main_table.increment_id')
				->columns('main_table.shipping_method')
				->columns('main_table.status')
				->columns('main_table.shipping_description')
				->columns('c.general_linksynceparcel_shipping_chargecode as general_linksynceparcel_shipping_chargecode')
				->columns("(case when c.consignment_number != '' then ( select count(*) from ".Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_article')." where consignment_number = c.consignment_number) else null end) as number_of_articles")
				->columns('is_address_valid as is_not_open')
				->joinLeft(array('c' => Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_consignment')),
						'main_table.entity_id = c.order_id and c.despatched=0')
				->where(' (main_table.shipping_method like "%linksynceparcel%" OR 
						   		(
								case 
								when (select count(*) from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_nonlinksync').' where method = main_table.shipping_description and  charge_code != "none") > 0 
								then 1 
								when (select charge_code from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_nonlinksync').' where method = main_table.shipping_description) = "none"
						   		then 0 
								else 1
								end
								) > 0
						)')
				->where(' ('.$status_condition.'
						   		(case when (select count(*) from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_consignment').' where order_id = main_table.entity_id) > 0 then (select count(*) from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_consignment').' where order_id = main_table.entity_id and despatched = 0) else 0 end) > 0
						)')
				->where("order_address.country_id='AU'")
				;
			/*echo $collection->getSelect()->__toString();
			exit;*/
			$this->setCollection($collection);
			return parent::_prepareCollection();
		}
		else
		{
			$collection = Mage::getModel('linksynceparcel/consignmentui')->getCollection();
			$collection
				->getSelect()
				->joinLeft(array('order_address' => Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address')),
						'main_table.shipping_address_id = order_address.entity_id')
				->reset(Zend_Db_Select::COLUMNS)
				->columns(new Zend_Db_Expr("CONCAT(`order_address`.`firstname`, ' ',`order_address`.`lastname`) AS fullname"))
				->columns('CONCAT(main_table.entity_id, "_",IFNULL(c.consignment_number,0)) as order_consignment')
				->columns('main_table.customer_firstname')
				->columns('main_table.customer_lastname')
				->columns('main_table.is_address_valid')
				->columns('main_table.increment_id')
				->columns('main_table.shipping_method')
				->columns('main_table.status')
				->columns('main_table.shipping_description')
				->columns('c.general_linksynceparcel_shipping_chargecode as general_linksynceparcel_shipping_chargecode')
				->columns("(case when c.consignment_number != '' then ( select count(*) from ".Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_article')." where consignment_number = c.consignment_number) else null end) as number_of_articles")
				->columns('is_address_valid as is_not_open')
				->joinLeft(array('c' => Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_consignment')),
						'main_table.entity_id = c.order_id and c.despatched=0')
				->where(' (main_table.shipping_method like "%linksynceparcel%" OR 
						   		(
								case 
								when (select count(*) from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_nonlinksync').' where method = main_table.shipping_description and  charge_code != "none") > 0 
								then 1 
								else 0
								end
								) > 0
						)')
				->where(' ('.$status_condition.' 
						   		(case when (select count(*) from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_consignment').' where order_id = main_table.entity_id) > 0 then (select count(*) from '.Mage::getSingleton('core/resource')->getTableName('linksync_linksynceparcel_consignment').' where order_id = main_table.entity_id and despatched = 0) else 0 end) > 0
						)')
				;
				
			/*echo $collection->getSelect()->__toString();
			exit;*/
			$this->setCollection($collection);
			return  parent::_prepareCollection();
		}
    }
 
    protected function _prepareColumns()
    {
		 $this->addColumn('increment_id', array(
            'header' => Mage::helper('linksynceparcel')->__('Order Number'),
            'align' => 'center',
            'index' => 'increment_id',
			'filter' => false,
            'sortable' => true,
			'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Ordernumber'
        ));
		
        $this->addColumn('customer_name', array(
          'header'    => Mage::helper('linksynceparcel')->__('Delivery To'),
          'align'     =>'left',
		  'width'	=> '150px',
          'index'     => 'fullname',
		  'filter' => false,
          'sortable' => true
        ));
		
		$display_order_status = (int)Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/display_order_status');
		if($display_order_status == 1)
		{
			$this->addColumn('status', array(
			  'header'    => Mage::helper('linksynceparcel')->__('Status'),
			  'align'     =>'center',
			  'index'     => 'status',
			  'filter' => false,
			  'sortable' => false,
			  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Status'
			));
		}
		
		$this->addColumn('weight', array(
          'header'    => Mage::helper('linksynceparcel')->__('Weight'),
          'align'     =>'center',
          'index'     => 'weight',
		  'filter' => false,
          'sortable' => true
        ));
	
        $this->addColumn('is_address_valid', array(
          'header'    => Mage::helper('linksynceparcel')->__('Address Valid'),
          'align'     =>'center',
          'index'     => 'is_address_valid',
          'type' => 'options',
            'options' => array(
                1 => 'Yes',
                0 => 'No',
            ),
			'sortable' => false,
			'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Addressvalid'
        ));
     
      $this->addColumn('consignment_number', array(
          'header'    => Mage::helper('linksynceparcel')->__('Consignment Number'),
          'align'     =>'center',
          'index'     => 'c.consignment_number',
		  'sortable' => true,
		  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Number'
      ));
	  
	  $this->addColumn('shipping_method', array(
          'header'    => Mage::helper('linksynceparcel')->__('Delivery Type'),
          'align'     =>'left',
          'index'     => 'shipping_method',
		  'type' => 'options',
          'options' => Mage::helper('linksynceparcel')->getDeliveryTypeOptions2(),
		  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Shippingmethod',
		  'sortable' => true,
		  'filter_condition_callback' => array($this, 'shippingMethodCondition')
      ));
	  
	  $this->addColumn('is_label_printed', array(
          'header'    => Mage::helper('linksynceparcel')->__('Labels Printed?'),
          'align'     =>'center',
          'index'     => 'c.is_label_printed',
		  'type' => 'options',
          'options' => array(
                1 => 'Yes',
                0 => 'No',
          ),
		  'sortable' => false,
		  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Labelprinted'
        ));
	  
	  $this->addColumn('is_return_label_printed', array(
          'header'    => Mage::helper('linksynceparcel')->__('Return Labels Printed?'),
          'align'     =>'center',
          'index'     => 'c.is_return_label_printed',
		  'type' => 'options',
          'options' => array(
                1 => 'Yes',
                0 => 'No',
          ),
		  'sortable' => false,
		  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Returnlabelprinted'
        ));
	  
	   $this->addColumn('is_next_manifest', array(
          'header'    => Mage::helper('linksynceparcel')->__('Next Manifest?'),
          'align'     =>'center',
          'index'     => 'c.is_next_manifest',
		  'type' => 'options',
          'options' => array(
                1 => 'Yes',
                0 => 'No',
          ),
		  'sortable' => false,
		  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Nextmanifest'
      ));
	   
	  $this->addColumn('number_of_articles', array(
          'header'    => Mage::helper('linksynceparcel')->__('No. of Articles'),
          'align'     =>'center',
          'index'     => 'number_of_articles',
		  'sortable' => true,
		  'filter' => false,
      ));

		 $this->addColumn('date_add', array(
		  'header'    => Mage::helper('linksynceparcel')->__('Date Created'),
		  'align'     =>'center',
		  'index'     => 'add_date',
		  'sortable' => true,
		  'filter' => false,
		  'renderer' => 'Linksync_Linksynceparcel_Block_Adminhtml_Renderer_Consignment_Date'
		));
         
        return parent::_prepareColumns();
    }
	
	protected function shippingMethodCondition($collection, $column) 
	{
 		if (!$value = $column->getFilter()->getValue())
			return;
		
		$this->getCollection()->getSelect()->where( "(main_table.shipping_method like '%_$value' or c.general_linksynceparcel_shipping_chargecode = '$value')" );
	}
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('order_consignment');
        $this->getMassactionBlock()->setFormFieldName('order_consignment');
		$this->getMassactionBlock()->setUseSelectAll(false); 

		$active = (int)Mage::getStoreConfig('carriers/linksynceparcel/active');
		if($active == 1)
		{
			$presetsArray = array();
			$use_order_total_weight = (int)Mage::getStoreConfig('carriers/linksynceparcel/use_order_total_weight');
			$use_article_dimensions = (int)Mage::getStoreConfig('carriers/linksynceparcel/use_article_dimensions');
			if($use_order_total_weight == 1)
			{
				$presetsArray['order_weight'] = 'Use Order Weight';
			}
			
			if($use_article_dimensions == 1)
			{
				$presets = Mage::getModel('linksynceparcel/preset')
						->getCollection()
						->addFilter('status', array('eq' => 1));
				if($presets->count() > 0)
				{
					foreach($presets as $preset)
					{
						$presetsArray[$preset->getName().'<=>'.$preset->getWeight().'<=>'.$preset->getHeight().'<=>'.$preset->getWidth().'<=>'.$preset->getLength()] = $preset->getName(). ' ('.$preset->getWeight().'kg - '.$preset->getHeight().'x'.$preset->getWidth().'x'.$preset->getLength().')';
					}
				}
			}
			
			if(count($presetsArray) > 0)
			{
				$statuses = array( 0 => 'No', 1 => 'Yes');
				
				$this->getMassactionBlock()->addItem('create', array(
					 'label'=> Mage::helper('linksynceparcel')->__('Create Consignment'),
					 'url'  => $this->getUrl('*/*/massCreateConsignment'),
					 'additional' => array(
							'presets' => array(
								 'name' => 'articles_type',
								 'type' => 'select',
								 'class' => 'required-entry articles_type-ui',
								 'label' => Mage::helper('catalog')->__('Article Presets'),
								 'values' => $presetsArray
							 ),
							'edit_default_consignment' => array(
								 'name' => 'edit_default_consignment',
								 'type' => 'select',
								 'label' => Mage::helper('catalog')->__('Edit Consignment Defaults'),
								 'values' => $statuses,
								 'onchange' => 'editdefaultconsignment(this)'
							 ),
							'partial_delivery_allowed' => array(
								 'name' => 'partial_delivery_allowed',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Partial Delivery allowed?'),
								 'values' => (Mage::getStoreConfig('carriers/linksynceparcel/partial_delivery_allowed')==1 ? array( 1 => 'Yes', 2 => 'No') : array( 0 => 'No', 1 => 'Yes'))
							 ),
							'delivery_signature_allowed' => array(
								 'name' => 'delivery_signature_allowed',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Delivery signature required?'),
								 'values' => (Mage::getStoreConfig('carriers/linksynceparcel/signature_required')==1 ? array( 1 => 'Yes', 2 => 'No') : array( 0 => 'No', 1 => 'Yes'))
							 ),
							'transit_cover_required' => array(
								 'name' => 'transit_cover_required',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Transit cover required?'),
								 'values' => (Mage::getStoreConfig('carriers/linksynceparcel/insurance')==1 ? array( 1 => 'Yes', 2 => 'No') : array( 0 => 'No', 1 => 'Yes'))
							 ),
							'transit_cover_amount' => array(
								 'name' => 'transit_cover_amount',
								 'type' => 'text',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Transit cover Amount'),
								 'value' => Mage::getStoreConfig('carriers/linksynceparcel/default_insurance_value')
							 ),
							'contains_dangerous_goods' => array(
								 'name' => 'contains_dangerous_goods',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Shipment contains dangerous goods?'),
								 'values' => $statuses
							 ),
							'print_return_labels' => array(
								 'name' => 'print_return_labels',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Print return labels?'),
								 'values' => (Mage::getStoreConfig('carriers/linksynceparcel/print_return_labels')==1 ? array( 1 => 'Yes', 2 => 'No') : array( 0 => 'No', 1 => 'Yes'))
							 ),
							'email_notification' => array(
								 'name' => 'email_notification',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Australia Post email notification?'),
								 'values' => (Mage::getStoreConfig('carriers/linksynceparcel/post_email_notification')==1 ? array( 1 => 'Yes', 2 => 'No') : array( 0 => 'No', 1 => 'Yes'))
							 ),
							'notify_customers' => array(
								 'name' => 'notify_customers',
								 'type' => 'select',
								 'class' => 'consignment-ui-hide',
								 'label' => Mage::helper('catalog')->__('Notify Customers?'),
								 'values' => (Mage::getStoreConfig('carriers/linksynceparcel/notify_customers')==1 ? array( 1 => 'Yes', 2 => 'No') : array( 0 => 'No', 1 => 'Yes'))
							 ),
					 )
				));
			}
			
			$this->getMassactionBlock()->addItem('generatelabels', array(
				 'label'=> Mage::helper('linksynceparcel')->__('Generate Labels'),
				 'url'  => $this->getUrl('*/*/massGenerateLabels')
			));
			
			$this->getMassactionBlock()->addItem('generatereturnlabels', array(
				 'label'=> Mage::helper('linksynceparcel')->__('Generate Return Labels'),
				 'url'  => $this->getUrl('*/*/massGenerateReturnLabels')
			));
			
			$this->getMassactionBlock()->addItem('unassign', array(
				 'label'=> Mage::helper('linksynceparcel')->__('Remove from Manifest'),
				 'url'  => $this->getUrl('*/*/massUnassignConsignment'),
				 'confirm' => Mage::helper('linksynceparcel')->__('Are you sure?')
			));
			
			$this->getMassactionBlock()->addItem('assign', array(
				 'label'=> Mage::helper('linksynceparcel')->__('Add to Manifest'),
				 'url'  => $this->getUrl('*/*/massAssignConsignment')
			));
			
			$this->getMassactionBlock()->addItem('delete', array(
				 'label'=> Mage::helper('linksynceparcel')->__('Delete Consignment'),
				 'url'  => $this->getUrl('*/*/massDeleteConsignment'),
				 'confirm' => Mage::helper('linksynceparcel')->__('Are you sure?')
			));
			
			if(trim(Mage::helper('linksynceparcel')->getStoreConfig('carriers/linksynceparcel/mark_despatch')) == 1)
			{
				$this->getMassactionBlock()->addItem('markdespatched', array(
					 'label'=> Mage::helper('linksynceparcel')->__('Mark as Despatched'),
					 'url'  => $this->getUrl('*/*/massMarkDespatched'),
					 'confirm' => Mage::helper('linksynceparcel')->__('Are you sure?')
				));
			}
		}
        return $this;
    }
}
