<?php
/**
 * Shopping Cart reports admin controller
 *
 * @category   Note
 * @package    Note_Mycart
 * @author     Manju G <manjumg11@gmail.com>
 */
class Note_Mycart_Adminhtml_Report_ShopcartController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        $this->loadLayout()
            ->_addBreadcrumb(Mage::helper('note_mycart')->__('Reports'), Mage::helper('note_mycart')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('note_mycart')->__('Shopping Cart'), Mage::helper('note_mycart')->__('Shopping Cart'));
        return $this;
    }

    

    

    public function mailmycartAction()
    {
        
        $this->_title($this->__('Reports'))
             ->_title($this->__('Shopping Cart'))
             ->_title($this->__('Abandoned Carts'));

        $this->_initAction()
            ->_setActiveMenu('report/shopcart')
            ->_addBreadcrumb(Mage::helper('note_mycart')->__('Abandoned Carts'), Mage::helper('note_mycart')->__('Abandoned Carts'))
            ->_addContent($this->getLayout()->createBlock('note_mycart/adminhtml_report_shopcart_abandoned'))
            ->renderLayout();
			
    }

   
}
