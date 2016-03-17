<?php
class Queenb_Productshowrule_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/productshowrule?id=15 
    	 *  or
    	 * http://site.com/productshowrule/id/15 	
    	 */
    	/* 
		$productshowrule_id = $this->getRequest()->getParam('id');

  		if($productshowrule_id != null && $productshowrule_id != '')	{
			$productshowrule = Mage::getModel('productshowrule/productshowrule')->load($productshowrule_id)->getData();
		} else {
			$productshowrule = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($productshowrule == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$productshowruleTable = $resource->getTableName('productshowrule');
			
			$select = $read->select()
			   ->from($productshowruleTable,array('productshowrule_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$productshowrule = $read->fetchRow($select);
		}
		Mage::register('productshowrule', $productshowrule);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function nopermissionAction(){
		Mage::getSingleton('core/session')->addError('You have no permission to open this product');
		$this->_redirect('');
	}
}