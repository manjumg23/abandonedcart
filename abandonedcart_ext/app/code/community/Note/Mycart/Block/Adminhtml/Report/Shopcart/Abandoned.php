<?php

/**
 * Adminhtml abandoned shopping cart report page content block
 *
 * @category   Note
 * @package    Note_Mycart
 * @author      Manju G <manjumg11@gmail.com>
 */
class Note_Mycart_Block_Adminhtml_Report_Shopcart_Abandoned extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
		$this->_blockGroup = 'note_mycart';
        $this->_controller = 'adminhtml_report_shopcart_abandoned';
        $this->_headerText = Mage::helper('note_mycart')->__('Abandoned carts notify');
        parent::__construct();
        $this->_removeButton('add');
    }


}
