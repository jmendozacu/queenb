<?php
class Queenb_Customercusexport_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/customercusexport?id=15 
    	 *  or
    	 * http://site.com/customercusexport/id/15 	
    	 */
    	/* 
		$customercusexport_id = $this->getRequest()->getParam('id');

  		if($customercusexport_id != null && $customercusexport_id != '')	{
			$customercusexport = Mage::getModel('customercusexport/customercusexport')->load($customercusexport_id)->getData();
		} else {
			$customercusexport = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($customercusexport == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$customercusexportTable = $resource->getTableName('customercusexport');
			
			$select = $read->select()
			   ->from($customercusexportTable,array('customercusexport_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$customercusexport = $read->fetchRow($select);
		}
		Mage::register('customercusexport', $customercusexport);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}