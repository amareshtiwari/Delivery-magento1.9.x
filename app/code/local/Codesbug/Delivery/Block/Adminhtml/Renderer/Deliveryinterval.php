<?php

/*
 * This renderer class use for show dates_type column
 */

class Codesbug_Delivery_Block_Adminhtml_Renderer_Deliveryinterval extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {

        $orderObj = Mage::getModel('sales/order')->load($row->getIncrementId(), "increment_id");
        $items = $orderObj->getData();
        $displayformat = Mage::getStoreConfig('datesection/date/timedisplayformat');
        $timefirst = $items['codesbug_delivery_timefirst'];
        $timelast = $items['codesbug_delivery_timelast'];

        if ($displayformat == 1) {
            if ($timefirst < 12) {
                $timefirst = $timefirst . 'AM';
            } else {
                if ($timefirst >= 13) {
                    $timefirst = $timefirst - 12;
                    $timefirst = number_format((float) $timefirst, 2, '.', '');
                    $timefirst = $timefirst . 'PM';
                } else {
                    $timefirst = number_format((float) $timefirst, 2, '.', '');
                    $timefirst = $timefirst . 'PM';
                }
            }
            if ($timelast < 12) {
                $timelast = $timelast . 'AM';
            } else {
                if ($timelast >= 13) {
                    $timelast = $timelast - 12;
                    $timelast = number_format((float) $timelast, 2, '.', '');
                    $timelast = $timelast . 'PM';
                } else {
                    $timelast = number_format((float) $timelast, 2, '.', '');
                    $timelast = $timelast . 'PM';
                }

            }
        }
        if (($items['codesbug_delivery_timefirst'] != '') && ($items['codesbug_delivery_timelast'] != '')) {
            $timeinterval = $timefirst . '-' . $timelast;
            return $timeinterval;
        }
    }

}
