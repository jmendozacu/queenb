<?php

class Queenb_Qtymgnt_Adminhtml_QtymgntController extends Mage_Adminhtml_Controller_action
{
	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('qtymgnt/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}
	public function saveeditdataAction() {
		$data = $this->getRequest()->getPost();
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$write->query("update mg_qtymgnt set title='".$data['txteditsetname']."' where qtymgnt_id='".$data['txteditsetidhidden']."'");
		$checkboxvar=$data['checkboxvaredit'];
		if(count($checkboxvar)){
			
			$write->query("delete from mg_qtymgntdetails where customergroup='".$data['txteditgrouphidden']."'");
			$lastInsertId = $data['txteditsetidhidden'];
			
			foreach($checkboxvar as $key => $val){
				$write->query("insert into mg_qtymgntdetails (qtymgnt_id,customergroup,qtyvalue,productid) values ('".$lastInsertId."','".$data['txteditgrouphidden']."','".$data['tareaaddqtyedit']."','".$val."')");
			}
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('qtymgnt')->__('Data save successfully'));
		}
		else
		{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('qtymgnt')->__('Unable to find item to save'));
		}
		$this->_redirect('*/*/');
        
	}
	public function editdataAction() {
		$id=$_GET['id'];
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$readresultweight=$write->query("select * from mg_qtymgnt where qtymgnt_id ='$id'");
		$AllDataresults=$readresultweight->fetchAll();
		foreach ($AllDataresults as $result)
		{
			$title=$result['title'];
		}
		
		$readresultweight=$write->query("select * from mg_qtymgntdetails where qtymgnt_id ='$id'");
		$AllDataresults=$readresultweight->fetchAll();
		foreach ($AllDataresults as $result)
		{
			$customergroup=$result['customergroup'];
			$qtyvalue=$result['qtyvalue'];
		}
		if($customergroup==0)
			$cs="NOT LOGGED IN";
		
		
		if($customergroup==1)
			$cs="General";
		
		if($customergroup==2)
			$cs="Wholesale";
			
		if($customergroup==3)
			$cs="Retailer";
		
		$str.="<ul>";
		$str.="<li><b>Set Name</b></li>";
		$str.="<li><input type='text' name='txteditsetname' id='txteditsetname' value='".$title."'><input type='hidden' name='txteditsetidhidden' id='txteditsetidhidden' value='".$id."'><input type='hidden' name='txteditgrouphidden' id='txteditgrouphidden' value='".$customergroup."'></li>";
		$str.="<li>&nbsp;</li>";
		$str.="<li><b>Customer section</b></li>";
		$str.="<li>$cs</li>";
		$str.="<li>&nbsp;</li>";
		
		
		$str.="<li><b>Set Qty</b>&nbsp;&nbsp;&nbsp;Multiply of <input type='text' value='0' name='txtqtymultiplyedit' id='txtqtymultiplyedit' />&nbsp;<input type=\"button\" value=\"Calculate\" onclick=\"funcalvalueedit();return false;\" />&nbsp;<input type=\"button\" value=\"Clear all\" onclick=\"funqtyaddclearalledit();return false;\" />&nbsp;Clear from : <input type=\"text\" value=\"10\" name=\"txtqtymultiplyclearfromedit\" id=\"txtqtymultiplyclearfromedit\" /> <input type=\"button\" value=\"Clear\" onclick=\"funqtyaddclearfromedit();return false;\" /></li>";
		$str.="<li><textarea name='tareaaddqtyedit' id='tareaaddqtyedit' style='width:668px;height:90px;'>$qtyvalue</textarea></li>";
		$str.="<li>&nbsp;</li>";
		
		
		$str.="<li><b>Product</b></li>";
		
		$productIds = array();
		$productIds[]=0;
		$readresultweight=$write->query("select * from mg_qtymgntdetails where customergroup ='$customergroup'");
		$AllDataresults=$readresultweight->fetchAll();
		foreach ($AllDataresults as $result)
		{
			$productIds[]=$result['productid'];
		}
		 $products = Mage::getModel('catalog/product')->getCollection();
		 $products->addAttributeToSelect('*');
		 $products->addAttributeToFilter('entity_id', array('nin' => $productIds));
		 $products->addAttributeToSort('name', 'ASC');
		 foreach($products as $prod){
			 $str.='<li><input type="checkbox" class="chkcheckbox" name="checkboxvaredit[]" value="'.$prod->getId().'">&nbsp;'.$prod->getName().'('.$prod->getSku().')'.'</li>';
		 }
		 
		 
		$productIdsedit = array();
		$productIdsedit[]=0;
		$readresultweight=$write->query("select * from mg_qtymgntdetails where customergroup ='$customergroup'");
		$AllDataresults=$readresultweight->fetchAll();
		foreach ($AllDataresults as $result)
		{
			$productIdsedit[]=$result['productid'];
		}
		 $products = Mage::getModel('catalog/product')->getCollection();
		 $products->addAttributeToSelect('*');
		 $products->addAttributeToFilter('entity_id', array('in' => $productIdsedit));
		 $products->addAttributeToSort('name', 'ASC');
		 foreach($products as $prod){
			 $str.='<li><input type="checkbox" class="chkcheckbox" name="checkboxvaredit[]" value="'.$prod->getId().'" checked>&nbsp;'.$prod->getName().'('.$prod->getSku().')'.'</li>';
		 }
		 $str.='<li><input type="button" value="Save" onclick="formsaveedit();return false;"></li>';
		$str.="</ul>";
		echo $str;
	}
	public function deletesetAction() {
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$write->query("delete from  mg_qtymgntdetails where qtymgnt_id='".$_GET['id']."'");
		$write->query("delete from mg_qtymgnt where qtymgnt_id='".$_GET['id']."'");
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('qtymgnt')->__('Delete record successfully.'));
		$this->_redirect('*/*/');
	}
	public function savesetAction() {
		$data = $this->getRequest()->getPost();
		$checkboxvar=$data['checkboxvar'];
		if(count($checkboxvar)){
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$write->query("insert into mg_qtymgnt (title,status,customergroup) values ('".$data['txtsetname']."','1','".$data['selcusgroup']."')");
			$lastInsertId = $write->lastInsertId();
			
			foreach($checkboxvar as $key => $val){
				$write->query("insert into  mg_qtymgntdetails (qtymgnt_id,customergroup,qtyvalue,productid) values ('".$lastInsertId."','".$data['selcusgroup']."','".$data['tareaaddqty']."','".$val."')");
			}
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('qtymgnt')->__('Data save successfully.'));
			echo "done";
		}
		else
		{
			echo "select product...";
		}
		
	}
 	public function fetchproductAction() {
			$gid=$_GET['gid'];
			$productIds = array();
			$productIds[]=0;
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$readresultweight=$write->query("select * from mg_qtymgntdetails where customergroup ='$gid'");
			$AllDataresults=$readresultweight->fetchAll();
			foreach ($AllDataresults as $result)
			{
				$productIds[]=$result['productid'];
			}
			 
			 $products = Mage::getModel('catalog/product')->getCollection();
			 $products->addAttributeToSelect('*');
			 $products->addAttributeToFilter('entity_id', array('nin' => $productIds));
			 $products->addAttributeToSort('name', 'ASC');
			 $str="<ul>";
			 foreach($products as $prod){
				 $str.='<li><input type="checkbox" class="chkcheckbox" name="checkboxvar[]" value="'.$prod->getId().'">&nbsp;'.$prod->getName().'('.$prod->getSku().')'.'</li>';
			 }
			 $str.="</ul>";
			 echo $str;
	}
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('qtymgnt/qtymgnt')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('qtymgnt_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('qtymgnt/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('qtymgnt/adminhtml_qtymgnt_edit'))
				->_addLeft($this->getLayout()->createBlock('qtymgnt/adminhtml_qtymgnt_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('qtymgnt')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
	  			
	  			
			$model = Mage::getModel('qtymgnt/qtymgnt');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('qtymgnt')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
		
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('qtymgnt')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('qtymgnt/qtymgnt');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $qtymgntIds = $this->getRequest()->getParam('qtymgnt');
        if(!is_array($qtymgntIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($qtymgntIds as $qtymgntId) {
                    $qtymgnt = Mage::getModel('qtymgnt/qtymgnt')->load($qtymgntId);
                    $qtymgnt->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($qtymgntIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $qtymgntIds = $this->getRequest()->getParam('qtymgnt');
        if(!is_array($qtymgntIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($qtymgntIds as $qtymgntId) {
                    $qtymgnt = Mage::getSingleton('qtymgnt/qtymgnt')
                        ->load($qtymgntId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($qtymgntIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'qtymgnt.csv';
        $content    = $this->getLayout()->createBlock('qtymgnt/adminhtml_qtymgnt_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'qtymgnt.xml';
        $content    = $this->getLayout()->createBlock('qtymgnt/adminhtml_qtymgnt_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}