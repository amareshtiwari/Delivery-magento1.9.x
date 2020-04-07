<?php
class Codesbug_delivery_Model_Pdf extends Mage_Sales_Model_Order_Pdf_Total_Default
{

    public function canDisplay()
    {
        return true;
    }
    public function getTotalsForDisplay()
    {
        $model = Mage::getModel('sales/order')->getCollection()->getData();
        $order = new Mage_Sales_Model_Order();
        $order1 = $this->getOrder();
        $order_id = (int) $order1->getRealOrderId();
        $order->loadByIncrementId($order_id);
        // $paymentMethod = $order->getPayment()->getMethodInstance()->getCode();
        $quote = Mage::getModel('sales/quote')->getCollection()->addFieldToFilter('reserved_order_id', $order_id)->getData();
        $fee = unserialize($quote[0]['fee']);

        $totals = array();
        foreach ($fee as $data) {
            $feeval[] = $data['fee'];
            $feelabel[] = $data['feelabel'];

            $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
            $totals = array(array(
                'label' => $feelabel,
                'amount' => $feeval,
                'font_size' => $fontSize,
            ),
            );
        }

        return $totals;
    }

}
