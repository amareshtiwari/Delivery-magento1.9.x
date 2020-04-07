<?php
/*
 * This renderer class use for show dates_type column
 */
class Codesbug_Delivery_Block_Adminhtml_Renderer_Customdate extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $type = $row->getData('dates_type');
        if ($type != null) {
            if ($type == 'timeinterval') {
                $time_from = $row->getData('time_from');
                //$time_from=str_replace(',',':', $time_from);
                $time_to = $row->getData('time_to');
                //$time_to=str_replace(',',':', $time_to);
                if ($time_to != null) {
                    return $time_from . ':00-' . $time_to . ':00';
                }
            }
            if ($type == 'dateinterval') {
                $date_from = $row->getData('date_from');
                $date_to = $row->getData('date_to');
                if ($date_to != null) {
                    return $date_from . ' : ' . $date_to;
                }
            }
            if ($type == 'allday') {
                $allday = $row->getData('all_day');
                return $allday;
            }
            if ($type == 'specificday') {
                $specific = $row->getData('specific_day');
                return $specific;
            }
            if ($type == 'datetimeinterval') {
                $time_from = $row->getData('datetime_from');
                $time_from = str_replace('.', ':', $time_from);
                $time_to = $row->getData('datetime_to');
                $time_to = str_replace('.', ':', $time_to);
                $specific = $row->getData('datespecific_day');
                if ($time_to != null) {
                    return $specific . '  ' . $time_from . '-' . $time_to;
                }
            }

        }

    }

}
