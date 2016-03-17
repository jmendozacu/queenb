<?php
/**
 * @copyright   Copyright (c) 2013 AZeBiz Co. LTD
 */
class Magebuzz_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction() {			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function searchAction() {
		$this->indexAction();
	}
}