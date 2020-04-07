<?php

class Codesbug_Delivery_Model_Status extends Varien_Object
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    public static function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED => Mage::helper('delivery')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('delivery')->__('Disabled'),
        );
    }
}
