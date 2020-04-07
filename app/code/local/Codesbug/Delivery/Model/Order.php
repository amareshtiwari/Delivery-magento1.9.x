<?php

class Codesbug_Delivery_Model_Order extends Mage_Sales_Model_Order
{
    /*
     * override getshippingdescription if Mage::registry('sending_order_email',1) return 1
     */

    public function getShippingDescription()
    {
        parent::getShippingDescription();
        $str = $this->getData('shipping_description');
        $date = $this->getCodesbugDeliveryDate();
        $comment = $this->getCodesbugDeliveryComment();
        if (!empty($date)) {
            $str .= '<br/>';
            $str .= 'Delivery Date: ' . $this->getCodesbugDeliveryDate() . '<br/>';
            $str .= 'Delivery Time:' . $this->getCodesbugDeliveryTimefirst() . '-' . $this->getCodesbugDeliveryTimelast();
        }
        if (!empty($comment)) {
            $str .= '<br/>';
            $str .= 'Delivery Comment: ' . $this->getCodesbugDeliveryComment();
        }

        if (!Mage::registry('sending_order_email', 1)) {
            return parent::getShippingDescription();
        } else {
            return $str;
        }
    }

    /*
     * make register and set value of sending_order_email to 1
     */

    public function sendNewOrderEmail()
    {
        Mage::register('sending_order_email', 1);
        return parent::sendNewOrderEmail();
        Mage::unregister('sending_order_email');
    }

}
