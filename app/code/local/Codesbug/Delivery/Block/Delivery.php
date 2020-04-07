<?php
class Codesbug_Delivery_Block_Delivery extends Mage_Core_Block_Template
{
/**
 * getDeliveryItem() function use get the delivery date from order table and use to show on frontend
 * on order view page
 **/
    public function getDeliveryItem()
    {
        $id = $this->getRequest()->getParams('id');
        $deliverydata = Mage::getModel('sales/order')->load($id);
        $data = $deliverydata->getData();
        return $data;
    }
    /*
     * The function timeInterval() use for show the dropdown of time interval which interval admin decide
     */
    public function timeInterval()
    {
        $timeinterval = Mage::getStoreConfig('datesection/date/timeinterval');
        return $timeinterval;
    }
    /*
     * This function get the time of
     */
    public function timeBufferSameDay()
    {
        $timebuffer = Mage::getStoreConfig('datesection/date/timebuffersameday');
        return $timebuffer;
    }

    /*
     *  getIsMandatory() function use for check datepicker is mandatory or not if return 1 then mandatory
     */

    public function getIsMandatory()
    {
        $ismandatory = Mage::getStoreConfig('datesection/date/ismandatory', Mage::app()->getStore());
        return $ismandatory;
    }
}
