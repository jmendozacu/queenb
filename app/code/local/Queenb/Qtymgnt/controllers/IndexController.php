<?php
class Queenb_Qtymgnt_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/qtymgnt?id=15 
    	 *  or
    	 * http://site.com/qtymgnt/id/15 	
    	 */
    	/* 
		$qtymgnt_id = $this->getRequest()->getParam('id');

  		if($qtymgnt_id != null && $qtymgnt_id != '')	{
			$qtymgnt = Mage::getModel('qtymgnt/qtymgnt')->load($qtymgnt_id)->getData();
		} else {
			$qtymgnt = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($qtymgnt == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$qtymgntTable = $resource->getTableName('qtymgnt');
			
			$select = $read->select()
			   ->from($qtymgntTable,array('qtymgnt_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$qtymgnt = $read->fetchRow($select);
		}
		Mage::register('qtymgnt', $qtymgnt);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
}