<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml abandoned shopping carts report grid block
 *
 * @category   Note
 * @package    Note_Mycart
 * @author     Manju G <manjumg11@gmail.com>
 */
class Note_Mycart_Block_Adminhtml_Report_Shopcart_Abandoned_Grid extends Mage_Adminhtml_Block_Report_Grid_Shopcart
{

	
    public function __construct()
    {
        parent::__construct();
        $this->setId('note_mycart_gridAbandoned');
		$this->setDefaultSort('increment_id');
        $this->setDefaultDir('DESC');
        //$this->setSaveParametersInSession(true);
        
    }

    protected function _prepareCollection()
    {
        /** @var $collection Mage_Reports_Model_Resource_Quote_Collection */
        $collection = Mage::getResourceModel('reports/quote_collection');

        $filter = $this->getParam($this->getVarNameFilter(), array());
        if ($filter) {
            $filter = base64_decode($filter);
            parse_str(urldecode($filter), $data);
        }

        if (!empty($data)) {
            $collection->prepareForAbandonedReport($this->_storeIds, $data);
        } else {
            $collection->prepareForAbandonedReport($this->_storeIds);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column)
    {
        $field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
        $skip = array('subtotal', 'customer_name', 'email'/*, 'created_at', 'updated_at'*/);

        if (in_array($field, $skip)) {
            return $this;
        }

        parent::_addColumnFilterToCollection($column);
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('customer_name', array(
            'header'    =>Mage::helper('note_mycart')->__('Cust Name'),
            'index'     =>'customer_name',
            'sortable'  =>false
        ));

        $this->addColumn('email', array(
            'header'    =>Mage::helper('note_mycart')->__('Email'),
            'index'     =>'email',
            'sortable'  =>false
        ));

        $this->addColumn('items_count', array(
            'header'    =>Mage::helper('note_mycart')->__('Number of Items'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'items_count',
            'sortable'  =>false,
            'type'      =>'number'
        ));

        $this->addColumn('items_qty', array(
            'header'    =>Mage::helper('note_mycart')->__('Quantity of Items'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'items_qty',
            'sortable'  =>false,
            'type'      =>'number'
        ));

        if ($this->getRequest()->getParam('website')) {
            $storeIds = Mage::app()->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
        } else if ($this->getRequest()->getParam('group')) {
            $storeIds = Mage::app()->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
        } else if ($this->getRequest()->getParam('store')) {
            $storeIds = array((int)$this->getRequest()->getParam('store'));
        } else {
            $storeIds = array();
        }
        $this->setStoreIds($storeIds);
        $currencyCode = $this->getCurrentCurrencyCode();

        $this->addColumn('subtotal', array(
            'header'        => Mage::helper('note_mycart')->__('Subtotal'),
            'width'         => '80px',
            'type'          => 'currency',
            'currency_code' => $currencyCode,
            'index'         => 'subtotal',
            'sortable'      => false,
            'renderer'      => 'adminhtml/report_grid_column_renderer_currency',
            'rate'          => $this->getRate($currencyCode),
        ));

        $this->addColumn('coupon_code', array(
            'header'    =>Mage::helper('note_mycart')->__('Applied Coupon'),
            'width'     =>'80px',
            'index'     =>'coupon_code',
            'sortable'  =>false
        ));

        $this->addColumn('created_at', array(
            'header'    =>Mage::helper('note_mycart')->__('Created At'),
            'width'     =>'170px',
            'type'      =>'datetime',
            'index'     =>'created_at',
            'filter_index'=>'main_table.created_at',
            'sortable'  =>false
        ));

        $this->addColumn('updated_at', array(
            'header'    =>Mage::helper('note_mycart')->__('Updated At'),
            'width'     =>'170px',
            'type'      =>'datetime',
            'index'     =>'updated_at',
            'filter_index'=>'main_table.updated_at',
            'sortable'  =>false
        ));

        $this->addColumn('remote_ip', array(
            'header'    =>Mage::helper('note_mycart')->__('IP Address'),
            'width'     =>'80px',
            'index'     =>'remote_ip',
            'sortable'  =>false
        ));

        $this->addExportType('*/*/exportAbandonedCsv', Mage::helper('note_mycart')->__('CSV'));
        $this->addExportType('*/*/exportAbandonedExcel', Mage::helper('note_mycart')->__('Excel XML'));

        return parent::_prepareColumns();
    }


 protected function _prepareMassaction()
    {
		        $this->setMassactionIdField('customer_email');
				$this->getMassactionBlock()->setFormFieldName('customer_email');
         
        // Append new mass action option 
        $this->getMassactionBlock()->addItem(
            'note_mycart',
            array('label' => $this->__('Send Email and Delete'), 
                  'url'   => $this->getUrl('*/sent/send'), //this should be the url where there will be mass operation
            )
        );
    	
	}
    public function getRowUrl($row)
    {
        return $this->getUrl('*/customer/edit', array('id'=>$row->getCustomerId(), 'active_tab'=>'cart'));
    }
}
