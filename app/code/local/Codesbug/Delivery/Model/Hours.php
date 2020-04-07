<?php

class Codesbug_Delivery_Model_Hours
{

    /**
     * Options getter
     *
     * @return array of dropdown time
     */
    public function toOptionArray()
    {
        $array = array();
        for ($i = 0; $i <= 24; $i++) {
            if ($i <= 12) {
                $array[] = array('value' => $i, 'label' => Mage::helper('delivery')->__($i . ':00 am'));
            } else {
                $array[] = array('value' => $i, 'label' => Mage::helper('delivery')->__($i - 12 . ':00 pm'));
            }
        }
        return $array;
    }

}
