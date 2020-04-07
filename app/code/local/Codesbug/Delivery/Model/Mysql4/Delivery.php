<?php

class Codesbug_Delivery_Model_Mysql4_Delivery extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the delivery_id refers to the key field in your database table.
        $this->_init('delivery/delivery', 'delivery_id');
    }
}
