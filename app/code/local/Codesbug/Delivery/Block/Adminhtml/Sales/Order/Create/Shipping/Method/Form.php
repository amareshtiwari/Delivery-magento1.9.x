
<?php

class Codesbug_Delivery_Block_Adminhtml_Sales_Order_Create_Shipping_Method_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Shipping_Method_Form
{

    protected function _toHtml()
    {
        $this->setTemplate('delivery/form.phtml');
        return parent::_toHtml();
    }

    public function geteditdata()
    {
        $session = Mage::getSingleton("core/session");
        $b = $session->getData("ordereditid");

        $model = Mage::getModel('sales/order')->getCollection()->addFilter('entity_id', $b);

        $data = $model->getData();

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

}

?>
