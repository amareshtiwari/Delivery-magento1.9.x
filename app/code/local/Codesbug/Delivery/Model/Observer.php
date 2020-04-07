<?php

class Codesbug_Delivery_Model_Observer extends Varien_Object
{
    /*
     * saveCodesbugDeliveryDate() function use to save deliverydate ,time,comment in quote table
     */

    public function saveCodesbugDeliveryDate($observer)
    {
        $postData = $observer->getRequest()->getPost();
        if (!empty($postData['shipdate']) || !empty($postData['timeinterval']) || !empty($postData['deliverycomment'])) {
            $deliveryDate = (empty($postData['shipdate'])) ? null : $postData['shipdate'];
            $deliveryTime = (empty($postData['timeinterval'])) ? null : $postData['timeinterval'];
            $deliveryComment = (empty($postData['deliverycomment'])) ? null : $postData['deliverycomment'];
            if ($deliveryDate) {
                $timeinterval = explode('-', $deliveryTime);
                $strfirst = $timeinterval[0];
                $str1 = str_replace(':', '.', $strfirst);
                $varfirst = floatval($str1);
                $strlast = $timeinterval[1];
                $str2 = str_replace(':', '.', $strlast);
                $varlast = floatval($str2);
                $observer->getQuote()->setCodesbugDeliveryDate($deliveryDate);
                $observer->getQuote()->setCodesbugDeliveryTimefirst($varfirst);
                $observer->getQuote()->setCodesbugDeliveryTimelast($varlast);
            }
            $observer->getQuote()->setCodesbugDeliveryComment($deliveryComment);
        }

    }

    /*
     * saveOrderBefore() function use to save deliverydate ,time,comment in order table
     */

    public function saveOrderBefore($evt)
    {
        $order = $evt->getOrder();
        $quote = $evt->getQuote();
        $order->setCodesbugDeliveryDate($quote->getCodesbugDeliveryDate());
        $order->setCodesbugDeliveryComment($quote->getCodesbugDeliveryComment());
        $order->setCodesbugDeliveryTimefirst($quote->getCodesbugDeliveryTimefirst());
        $order->setCodesbugDeliveryTimelast($quote->getCodesbugDeliveryTimelast());
    }

    /*
     * coreBlockAbstractToHtmlBefore() use to override the product order grid
     */

    public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        /** @var $block Mage_Core_Block_Abstract */

        $block = $observer->getEvent()->getBlock();
        if (!isset($block)) {
            return $this;
        }

        if ($block->getType() == 'adminhtml/sales_order_grid') {

            $block->addColumnAfter('Delivery_Date', array(
                'header' => 'Delivery Date',
                'type' => 'date',
                'index' => 'Delivery_Date',
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'deliverydate'),
            ), 'shipping_name');

            $block->addColumnAfter('Delivery_Time', array(
                'header' => 'Delivery Time',
                'type' => 'text',
                'width' => '150px',
                'index' => 'Delivery_Time',
                'sortable' => true,
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'deliverytime'),
                'renderer' => new Codesbug_Delivery_Block_Adminhtml_Renderer_Deliveryinterval(),
            ), 'Delivery_Date');
            $block->addColumnAfter('Delivery_Comment', array(
                'header' => 'Delivery Comment',
                'type' => 'text',
                'index' => 'Delivery_Comment',
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'deliverycomment'),
            ), 'Delivery_Time');
            $block->addColumnAfter('purchase _date', array(
                'header' => Mage::helper('sales')->__('Purchased On'),
                'index' => 'created_at',
                'type' => 'datetime',
                'width' => '100px',
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'filterPurchasedate'),
            ), 'created_at');
            $block->addColumnAfter('Purchased_total', array(
                'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
                'index' => 'grand_total',
                'type' => 'currency',
                'currency' => 'order_currency_code',
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'filterPurchase'),
            ), 'Delivery_Comment');
            $block->addColumnAfter('base_total', array(
                'header' => Mage::helper('sales')->__('G.T. (Base)'),
                'index' => 'base_grand_total',
                'type' => 'currency',
                'currency' => 'base_currency_code',
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'filterTotal'),
            ), 'grand_total');
            $block->addColumnAfter('codesbugstatus', array(
                'header' => Mage::helper('sales')->__('Status'),
                'index' => 'status',
                'type' => 'options',
                'width' => '100px',
                'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'filterStatus'),
            ), 'base_total');
            $block->addColumnAfter('real_order', array(
                'header' => Mage::helper('sales')->__('Order #'),
                'width' => '80px',
                'type' => 'text',
                'index' => 'increment_id',
                'filter_condition_callback' => array(Mage::getSingleton('Codesbug_Delivery_Model_Observer'), 'filterOrder'),
            ), 'increment_id');

        }
    }

    /*
     * salesOrderGridCollectionLoadBefore() use to get the data of new grid by using join
     */

    public function salesOrderGridCollectionLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getOrderGridCollection();
        $select = $collection->getSelect();
        $select->joinLeft(array('payment' => $collection->getTable('sales/order')), 'payment.entity_id=main_table.entity_id', array('Delivery_Date' => 'codesbug_delivery_date', 'Delivery_Comment' => 'codesbug_delivery_comment', 'Delivery_Time' => 'CONCAT(payment.codesbug_delivery_timefirst, "-" ,payment.codesbug_delivery_timelast )'));
        // die();
    }

    //$select->joinLeft( array('full_address_ship' => 'CONCAT(soas.firstname, " " , soas.lastname, ",<br/>", soas.street, ",<br/>", soas.city, ",<br/>", soas.region, ",<br/>", soas.postcode)',
    //   'full_address' => 'CONCAT(soas.firstname " "  soas.lastname)'), null);

    public function coreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block->getType() == 'adminhtml/sales_order_grid') {
            $datetime = Mage::getStoreConfig('datesection/date/showdeliverydatetime');
            $comment = Mage::getStoreConfig('datesection/date/showdeliverycomment');
            if ($datetime == 0) {
                $block->removeColumn('Delivery_Time');
                $block->removeColumn('Delivery_Date');
            }
            if ($comment == 0) {
                $block->removeColumn('Delivery_Comment');
            }
            $block->removeColumn('created_at');
            $block->removeColumn('base_grand_total');
            $block->removeColumn('grand_total');
            $block->removeColumn('status');
            $block->removeColumn('real_order_id');
        }
    }

    /*
     * searching on the delivery comment
     */

    public function deliverycomment($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $select = $collection->getSelect();
        $select->joinLeft(array('delivery' => $collection->getTable('sales/order')), 'delivery.entity_id=main_table.entity_id', array('codesbug_delivery_date', 'codesbug_delivery_comment'))->where("`delivery`.`codesbug_delivery_comment` like?", "%$value%");
        return $this;
    }

    /*
     * searching on the delivery time
     */

    public function deliverytime($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $timeinterval = array();
        $value = str_replace(':', '.', $value);

        $timeinterval = explode('-', $value);

        if (sizeof($timeinterval) < 2) {
            $strlast = 24.00;
        } else {
            if ($timeinterval[1] == '') {
                $strlast = 24.00;
            } else {
                $strlast = $timeinterval[1];
            }
        }
        $strfirst = $timeinterval[0];
        $varfirst = floatval($strfirst);

        $varlast = floatval($strlast);

        $select = $collection->getSelect();

        $select->joinLeft(array('delivery' => $collection->getTable('sales/order')), 'delivery.entity_id=main_table.entity_id', array('codesbug_delivery_date', 'codesbug_delivery_comment'))->where("`delivery`.`codesbug_delivery_timefirst` >=$varfirst AND `delivery`.`codesbug_delivery_timelast` <= ?", "$varlast");

        return $this;
    }

    /*
     * searching on the delivery date feild
     */

    public function deliverydate($collection, $from)
    {
        if (!$value = $from->getFilter()->getValue()) {
            return $this;
        }

        if ((!isset($value['orig_from'])) || (!isset($value['orig_to']))) {
            if (!isset($value['orig_to'])) {
                $to = $value['orig_from'];
                $from = $value['orig_from'];
            } else {
                $from = $value['orig_to'];
                $to = $value['orig_to'];
            }
        } else {
            $to = $value['orig_to'];
            $from = $value['orig_from'];
        }

        $fromchange = $from;
        $tochange = $to;

        $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($fromchange));
        $fromnew = date('Y-m-d', $dateTimestamp);
        $dateTimestampto = Mage::getModel('core/date')->timestamp(strtotime($tochange));
        $tonew = date('Y-m-d', $dateTimestampto);

        $select = $collection->getSelect();
        $select->joinLeft(array('deliverydate' => $collection->getTable('sales/order')), 'deliverydate.entity_id=main_table.entity_id', array('codesbug_delivery_date', 'codesbug_delivery_comment'))->where("`deliverydate`.`codesbug_delivery_date` BETWEEN '$fromnew' AND '$tonew'");
        return $this;
    }

    /*
     * searching on the purchasedate date feild
     */

    public function filterPurchasedate($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $from = $value['from'];
        $to = $value['to'];
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.created_at between '$from' and '$to'")->group('main_table.entity_id');
    }

    public function filterTotal($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $from = $value['from'];
        $to = $value['to'];
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.base_grand_total between '$from' and '$to'")->group('main_table.entity_id');
    }

    public function filterPurchase($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }

        $from = $value['from'];
        $to = $value['to'];

        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.base_grand_total between '$from' and '$to'")->group('main_table.entity_id');
    }
    public function filterStatus($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->joinLeft(array('status_filter' => $collection->getTable('sales/order')), 'status_filter.entity_id=main_table.entity_id', array('status_filter.status'))
            ->where("status_filter.status like ?", "%$value%")->group('main_table.entity_id');
    }

    public function filterOrder($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.increment_id like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

}
