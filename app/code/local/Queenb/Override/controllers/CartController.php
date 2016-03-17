<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class Queenb_Override_CartController extends Mage_Checkout_CartController
{
	public function addAction()
	{
		echo 'I successfully Override Cart Controller';
		exit;
	}
}
?> 