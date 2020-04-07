<?php

class Codesbug_Delivery_Model_Format
{

    /**
     * Options getter
     *
     * @return array of dropdown formats
     */
    public function toOptionArray()
    {
        $array = array(
            array(
                'label' => Mage::helper('delivery')->__('24 hour format'),
                'value' => 0,
            ),
            array(
                'label' => Mage::helper('delivery')->__('AM/PM format'),
                'value' => 1,
            ),
        );
        return $array;
    }

}
