<?php
/**
 * @copyright   Copyright (c) 2009-2011 Amasty (http://www.amasty.com)
 */ 
class Amasty_Scroll_Model_Observer
{
    public function onListBlockHtmlAfter($observer)
    {
        $productListBlock = Mage::app()->getLayout()->getBlockSingleton('catalog/product_list');
        $class = get_class($productListBlock);
        if (!($observer->getBlock() instanceof $class) || Mage::app()->getRequest()->getParam('is_ajax', false)) {
            return;
        }
        $html = $observer->getTransport()->getHtml();
        $productToolbarBlock = Mage::app()->getLayout()->getBlockSingleton('catalog/product_list_toolbar');
        $productToolbarBlock->setCollection($productListBlock->getLoadedProductCollection());

		$addHtml = '<div class="pager" style="display: none !important;">
						<p class="amount">'
            . $productListBlock->__('Items %s to %s of %s total', $productToolbarBlock->getFirstNum(), $productToolbarBlock->getLastNum(), $productToolbarBlock->getTotalNum()).
            '</p>
					</div>';
		$html .= $addHtml;
		$observer->getTransport()->setHtml($html);
	}

    public function handleLayoutRender()
    {
        $isScroll = Mage::app()->getRequest()->getParam('is_scroll');
        if(!$isScroll) {
            return;
        }
        $layout = Mage::getSingleton('core/layout');
        if (!$layout)
            return;
            
        $isAJAX = Mage::app()->getRequest()->getParam('is_ajax', false);
        $isAJAX = $isAJAX && Mage::app()->getRequest()->isXmlHttpRequest();
        if (!$isAJAX)
            return;
            
        $layout->removeOutputBlock('root');    
        Mage::app()->getFrontController()->getResponse()->setHeader('content-type', 'application/json');
            
		$page = Mage::helper('amscroll')->findProductList($layout);
		if (!$page) {
			return;
		}
        die(
            Mage::helper('core')->jsonEncode(
                array(
                    'page' => $this->_removeAjaxParam($page->toHtml())
                )
            )
        );
    }
    
    protected function _removeAjaxParam($html)
    {
        $html = str_replace('is_ajax=1&amp;', '', $html);
        $html = str_replace('is_ajax=1&',     '', $html);
        $html = str_replace('?is_ajax=1',     '', $html);
        $html = str_replace('is_ajax=1',      '', $html);

        $html = str_replace('?___SID=U', '', $html);
        $html = str_replace('___SID=U',  '', $html);
        
        return mb_convert_encoding($html , 'UTF-8', mb_detect_encoding($html) );
    }
}