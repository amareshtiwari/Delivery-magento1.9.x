<?php

class Codesbug_Delivery_IndexController extends Mage_Core_Controller_Front_Action
{ /*
 * The editorderAction() action use to edit the delivery items in admin view order page
 */

    public function editorderAction()
    {
        $orderid = $this->getRequest()->getParam('orderid');
        $deliverydate = $this->getRequest()->getPost('codesbug_delivery_date');
        $deliverytime = $this->getRequest()->getPost('time_interval');
        $deliverycomment = $this->getRequest()->getPost('deliverycomment');
        $storecomment = $this->getRequest()->getPost('storecomment');
        $notifyemail = $this->getRequest()->getPost('notifyemail');

        $deliverycomment = preg_replace("/\r\n|\r/", "<br/>", $deliverycomment);
        $deliverycomment = trim($deliverycomment);

        $a = explode('-', $deliverytime);
        $model = Mage::getModel('sales/order')->load($orderid);
        $deliverydatebefore = $model->getCodesbugDeliveryDate();
        $deliverytimefirstbefore = $model->getCodesbugDeliveryTimefirst();
        $deliverytimelastbefore = $model->getCodesbugDeliveryTimelast();
        $customername = $model->getCustomerName();
        $status = $model->getStatus();

        $currtime = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));

        $model->setCodesbugDeliveryDate($deliverydate);
        $model->setCodesbugDeliveryComment($deliverycomment);
        $model->setCodesbugDeliveryTimefirst($a[0]);
        $model->setCodesbugDeliveryTimelast($a[1]);

        /*
         * order comment
         */
        $comment = 'Delivery Information Changes From ' . $deliverydatebefore . ' ' . $deliverytimefirstbefore . '-' . $deliverytimelastbefore . ' To ' . $deliverydate . ' ' . $deliverytime . ' By ' . $customername . ' at ' . $currtime . '<br/>';
        $comment .= $storecomment;

        $deliveryinformation = 'Delivery Date:' . $deliverydate . '<br/>';
        $deliveryinformation .= 'Delivery Time:' . $deliverytime . '<br/>';
        $deliveryinformation .= 'Delivery Comment:' . $deliverycomment . '<br/><br/>';
        $deliveryinformation .= $comment;

        if (isset($notifyemail)) { //check the notify email is checked or not ,checked then email send
            try {
                //$data = array();
                //$data['comment'] = $comment;
                //$data['status'] = $status;
                $model->addStatusHistoryComment($comment, $status);
                // $comment = trim(strip_tags($data['comment']));

                $model->save();
                $model->sendOrderUpdateEmail($status, $deliveryinformation);
            } catch (Mage_Core_Exception $e) {
                $response = array(
                    'error' => true,
                    'message' => $e->getMessage(),
                );
            } catch (Exception $e) {
                $response = array(
                    'error' => true,
                    'message' => $this->__('Cannot add order history.'),
                );
            }
        }

        $this->_redirectReferer();

    }

}
