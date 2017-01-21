<?php
require_once 'Mage/Catalog/Model/Product.php';
 

require_once 'Mage/Adminhtml/controllers/Sales/Order/InvoiceController.php';
 
class Note_Mycart_Adminhtml_SentController extends Mage_Adminhtml_Sales_Order_InvoiceController
{
    public function sendAction(){
		
						
					
						ini_set('display_errors','on');
        require_once 'app/Mage.php';
        Mage::app('default');
        $products = Mage::getModel('catalog/product')->load('1296'); //Product ID
		echo  Mage::helper('catalog/image')->init($products, 'thumbnail');
		$imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product' . $products->getImage();
$imageCacheUrl = Mage::helper('catalog/image')->init($products, 'image')->resize(135,135);
echo $imageUrl;
echo $imageCacheUrl;
        echo "<pre>";
        //print_r($products);
        echo $products->getImage();
        echo "<br>";
        echo $products->getSmallImage();
        echo "<br>";
        echo $products->getThumbnail();
        echo "<br>";
        echo Mage::helper('catalog/image')->init($products, 'small_image')->resize(163,100); // resize function is used to resize image
        echo "<br>";
        echo Mage::helper('catalog/image')->init($products, 'image')->resize(400,400);
						
						
						
						
						
				$resource = Mage::getSingleton('core/resource');

				$readConnection = $resource->getConnection('core_read');

				$writeConnection = $resource->getConnection('core_write');
				
				
				$resource_product = Mage::getSingleton('core/resource');

				$readConnection_product = $resource->getConnection('core_read');

				$writeConnection_product = $resource->getConnection('core_write');


	
	
				$EntityIds = array();
				$EntityIds=$this->getRequest()->getParam('customer_email');
		 
				foreach($EntityIds as $value){	 
				 $collection = Mage::getResourceModel('reports/quote_collection')
				->addFieldToFilter('entity_id', $value)
				->load();
				
		
				
				foreach($collection as $data){
							 
							 echo $data->getData('customer_email'); echo " : "; echo $data->getData('reserved_order_id'); 
							 echo $data->getData('entity_id');
							 echo $data->getData('product_name');
							 $quote_item_id=$data->getData('entity_id');
							
							$query = 'SELECT * FROM ' . $resource->getTableName('sales/quote_item').' WHERE quote_id ='.$quote_item_id;
							$results = $readConnection->fetchAll($query);
							$product_id_test="1468";
							
															
							$count=1;
							foreach($results as $res){
								echo "</br>";
								echo "count: ".$count;
								echo "</br>";
								echo "Product Id:". $res['product_id'];
								echo "</br>";
								echo "Product Name:".$res['name'];
								$count++;
								$pr_id=$res['product_id'];
								$query_pr= 'SELECT * FROM catalog_product_entity_media_gallery WHERE entity_id = '.$pr_id;
							
							
							$results_pr= $readConnection_product->fetchAll($query_pr);
							
							foreach($results_pr as $res){
								echo "Product Image:".$res['value'];
								
							}
								
								
							}
													
								
							 
							 echo '</br>';
							 
							 
							 
							 
							           $emailTemplate = Mage::getModel('core/email_template')->loadDefault('note_cart');

										//Getting the Store E-Mail Sender Name.
										$senderName = "Manjunath";
										$customerEmail=$data->getData('customer_email');
										//Getting the Store General E-Mail.
										$senderEmail = "manjumg11@gmail.com";

										//Variables for Confirmation Mail.
										$emailTemplateVariables = array();
										$emailTemplateVariables['name'] = "Manju";
										$emailTemplateVariables['email'] = "manjumg23@gmail.com";

										//Appending the Custom Variables to Template.
										$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

										//Sending E-Mail to Customers.
										$mail = Mage::getModel('core/email')
										 ->setToName($senderName)
										 ->setToEmail($customerEmail)
										 ->setBody($processedTemplate)
										 ->setSubject('Subject :')
										 ->setFromEmail($senderEmail)
										 ->setFromName($senderName)
										 ->setType('html');
										 try{
										 //Confimation E-Mail Send
										 //$mail->send();
										 }
										 catch(Exception $error){
										 Mage::getSingleton('core/session')->addError($error->getMessage());
										 return false;
									    }	 
							 
				}				
				
				
				
				
		}
	}
 
}