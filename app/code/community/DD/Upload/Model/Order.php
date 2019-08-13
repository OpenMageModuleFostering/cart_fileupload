<?php

/**
 * Dynamic Dreamz
 * @category   DD
 * @package    DD_Upload
 * @copyright  Copyright (c) 2014-2015 Dynamic Dreamz. (http://www.dynamicdreamz.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */


class DD_Upload_Model_Order extends Mage_Core_Model_Abstract {

    protected function _construct() {

        $this->_init("upload/order");
    }

    /**
     * save record of particular uploaded file
     * @param string $order_id
     * @param string $filename
     * @param string $type
     */
    public function saveFile($order_id, $filename, $type) {
        $this->setFilename($filename);
        $this->setOrderId($order_id);
        $this->setType($type);
        $this->save();
    }

    /**
     * get all uploaded file records 
     * @param object $order
     * @return object
     */
    public function getFiles($order) {
        $collection = Mage::getSingleton('upload/order')->getCollection();
        $collection->addFieldToFilter('order_id', $order->getId());
        return $collection;
    }

}
