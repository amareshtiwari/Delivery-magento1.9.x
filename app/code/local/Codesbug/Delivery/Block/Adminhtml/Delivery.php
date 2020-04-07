<?php

class Codesbug_Delivery_Block_Adminhtml_Delivery extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_delivery';
        $this->_blockGroup = 'delivery';
        $this->_headerText = Mage::helper('delivery')->__('Disabled Dates Manager');
        $this->_addButtonLabel = Mage::helper('delivery')->__('Add Dates');
        parent::__construct();
    }
    /*
     *  getDeliveryItem() function use for the get delivery items data from sales_flat_order ,like delivery date
     */
    public function getDeliveryItem()
    {
        $orderid = $this->getRequest()->getParams('id');
        $id = $orderid['order_id'];
        $deliverydata = Mage::getModel('sales/order')->load($id);
        $data = $deliverydata->getData();
        return $data;
    }

    /*
     * This function use to show the delivery date on shipment page
     */
    public function getShipmentItems()
    {
        $id = $this->getRequest()->getParams('id');
        $cid = $id['shipment_id'];
        $model = Mage::getModel('sales/order_shipment')->load($cid);
        $orderid = $model->getOrderId();
        $deliverydata = Mage::getModel('sales/order')->load($orderid);
        $data = $deliverydata->getData();
        return $data;

    }
    /*
     * This function use to show the delivery date on invoice page
     */
    public function getInvoiceItems()
    {
        $id = $this->getRequest()->getParams('id');
        $cid = $id['invoice_id'];
        $model = Mage::getModel('sales/order_invoice')->load($cid);
        $orderid = $model->getOrderId();
        $deliverydata = Mage::getModel('sales/order')->load($orderid);
        $data = $deliverydata->getData();
        return $data;

    }
    /*
     *  getIsMandatory() function use for check datepicker is mandatory or not if return 1 then mandatory
     */

    public function getIsMandatory()
    {
        $ismandatory = Mage::getStoreConfig('datesection/date/ismandatory', Mage::app()->getStore());
        return $ismandatory;
    }
    /*
     * get the value of Display format for time dropdown
     */
    public function getDisplayFormatTime()
    {
        $displayformat = Mage::getStoreConfig('datesection/date/timedisplayformat');
        return $displayformat;
    }
    /*
     * The function timeInterval() use for show the dropdown of time interval which interval admin decide
     */
    public function timeInterval()
    {
        $timeinterval = Mage::getStoreConfig('datesection/date/timeinterval');
        return $timeinterval;
    }

}
