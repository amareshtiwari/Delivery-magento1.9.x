<?php

class Codesbug_Delivery_Block_Checkout_Onepage_Shipping_Method_Additional extends Mage_Checkout_Block_Onepage_Shipping_Method_Additional
{
    /*
     * getMinDeliveryInterval() function use to get the mindeliveryinterval which is given by the admin
     */

    public function getMinDeliveryInterval()
    {
        $mindeliveryinterval = Mage::getStoreConfig('datesection/date/mindeliveryinterval');
        $date = new Zend_Date(Mage::getModel('core/date')->timestamp());
        $d = $date->addDay($mindeliveryinterval);
        return $d;
    }

    /*
     *  getMaxDeliveryInterval() function use to get the maxdeliveryinterval which is given by the admin
     */

    public function getMaxDeliveryInterval()
    {
        $maxdeliveryinterval = Mage::getStoreConfig('datesection/date/maxdeliveryinterval');
        $datem = new Zend_Date(Mage::getModel('core/date')->timestamp());
        $currentdate = $datem->toString('d');
        $maxdateinterval = $datem->addDay($maxdeliveryinterval);
        return $maxdateinterval;
    }

    /*
     *  getCurrentDate() function use to get the currentdate
     */

    public function getCurrentDate()
    {
        $curr = new Zend_Date(Mage::getModel('core/date')->timestamp());
        $currentdate = $curr;
        return $currentdate;
    }

    /*
     *  getCurrentMonth() function use to get the currentmonth
     */

    public function getCurrentMonth()
    {
        $curr = new Zend_Date(Mage::getModel('core/date')->timestamp());
        $currentmonth = $curr->toString('M');
        return $currentmonth;
    }

    /*
     *  getMaxInterval() function use to get the maxdeliveryinterval
     */

    public function getMaxInterval()
    {
        $maxdel = Mage::getStoreConfig('datesection/date/maxdeliveryinterval');
        return $maxdel;
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
     *  getMaxTimeSameDay() function use get the maxtime for same day
     */

    public function getMaxTimeSameDay()
    {
        $curr = new Zend_Date(Mage::getModel('core/date')->timestamp());
        $currenttime = $curr->toString('H');
        $maxtimesameday = Mage::getStoreConfig('datesection/date/maxtimesameday', Mage::app()->getStore());
        if (($maxtimesameday >= $currenttime)) {
            $true = 0;
        } else {
            $true = 1;
        }
        return $true;
    }

    /*
     *  getMaxHourForNextDay() function use get the maxhour for next day and use for next day show or not
     * here we check current time is lessthen equalto or not
     */

    public function getMaxHourForNextDay()
    {
        $curr = new Zend_Date(Mage::getModel('core/date')->timestamp());
        $currenttime = $curr->toString('H');
        $maxtimesameday = Mage::getStoreConfig('datesection/date/maxhourfornextday', Mage::app()->getStore());
        if ($maxtimesameday <= $currenttime) {
            $true = 1;
        } else {
            $true = 0;
        }
        return $true;
    }

    /*
     * getDeliveryComment() this function use to get the comment which is written by admin
     */

    public function getDeliveryComment()
    {
        $deliverycomment = Mage::getStoreConfig('datesection/date/deliverycomment');
        return $deliverycomment;
    }

    public function getDeliveryDisplaysetting()
    {
        $model = Mage::getModel('delivery/delivery')->getCollection();
        $data = $model->getData();
        $alldays = array(
            "0" => "Sunday",
            "1" => "Monday",
            "2" => "Tuesday",
            "3" => "Wednesday",
            "4" => "Thursday",
            "5" => "Friday",
            "6" => "Saturday",
        );
        $a = array();
        /*
         * check column name is dates_type=allday , then swap days value to key value of $alldays array
         */
        foreach ($data as $d) {
            if ($d['dates_type'] == 'allday') {
                foreach ($alldays as $key => $aday) {
                    if ($aday == $d['all_day']) {
                        $a[] = $key;
                    }
                }
            }
        }

        return $a;
    }

    public function getDeliveryDisableDates()
    {
        $model = Mage::getModel('delivery/delivery')->getCollection();
        $data = $model->getData();

        $a = array();
        /*
         * check column name is dates_type=specific_day , then put date value in array and return array
         */
        foreach ($data as $d) {
            if ($d['dates_type'] == 'specificday') {
                $a[] = $d['specific_day'];
            }
        }

        return $a;
    }

    public function getDeliveryDisableDateInterval()
    {
        $model = Mage::getModel('delivery/delivery')->getCollection();
        $data = $model->getData();
        $array1 = array();
        $array2 = array();
        $arrayboth = array();
        /*
         * check column name is dates_type=specific_day , then put date value in array and return array
         */
        foreach ($data as $d) {
            if ($d['dates_type'] == 'dateinterval') {
                $array1[] = $d['date_from'];
                $array2[] = $d['date_to'];
            }
        }
        $arrayboth[] = $array1;
        $arrayboth[] = $array2;
        return $arrayboth;
    }

    public function getDeliveryDisableTimeInterval()
    {
        $model = Mage::getModel('delivery/delivery')->getCollection();
        $data = $model->getData();
        $array1 = array();
        $array2 = array();
        $arrayboth = array();
        /*
         * check column name is dates_type=specific_day , then put date value in array and return array
         */
        foreach ($data as $d) {
            if ($d['dates_type'] == 'timeinterval') {
                $array1[] = $d['time_from'];
                $array2[] = $d['time_to'];
            }
        }
        $arrayboth[] = $array1;
        $arrayboth[] = $array2;
        return $arrayboth;
    }

    public function getDeliveryDisableDateTimeInterval()
    {
        $model = Mage::getModel('delivery/delivery')->getCollection();
        $data = $model->getData();
        $array1 = array();
        $array2 = array();
        $array3 = array();
        $arrayboth = array();
        /*
         * check column name is dates_type=specific_day , then put date value in array and return array
         */
        foreach ($data as $d) {
            if ($d['dates_type'] == 'datetimeinterval') {
                $array1[] = $d['datetime_from'];
                $array2[] = $d['datetime_to'];
                $array3[] = $d['datespecific_day'];
            }
        }
        $arrayboth[] = $array1;
        $arrayboth[] = $array2;
        $arrayboth[] = $array3;
        return $arrayboth;
    }

    /*
     * get the value of Display format for time dropdown
     */
    public function getDisplayFormatTime()
    {
        $displayformat = Mage::getStoreConfig('datesection/date/timedisplayformat');
        return $displayformat;
    }
}
