<?php

 
class Note_Mycart_Adminhtml_SentController 
{
    public function sendAction(){
        
		echo "checking Note";
		 $productIds = $this->getRequest()->getParam('email');
		 echo "hi".$productIds;
		 var_dump($productIds);
		 
		
    }
 
}