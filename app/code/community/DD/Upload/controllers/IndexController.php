<?php

/**
 * Dynamic Dreamz
 * @category   DD
 * @package    DD_Upload
 * @copyright  Copyright (c) 2014-2015 Dynamic Dreamz. (http://www.dynamicdreamz.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class DD_Upload_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * file upload action
     */
    public function uploadAction() {
        $totalItemsInCart = Mage::helper('checkout/cart')->getItemsCount();
        $_flag = 0;
        if ($totalItemsInCart > 0) {
            if ($data = $this->getRequest()->getPost()) {
                $arrData = array();
                $type = 'file';
                $flag = 'on';
                $_fileSize = Mage::getStoreConfig("generalsettings/configuration/upload_filesize");
                $_maxNoFile = (int)Mage::getStoreConfig("generalsettings/configuration/maxuploadlimit");
                if (isset($_FILES[$type]['name']) && $_FILES[$type]['name'] != '' && isset($_FILES[$type]['size'])) {
                    try {
                        $_fileSizeCreate = $_FILES[$type]['size'];
                        $quote_id = Mage::getSingleton('checkout/session')->getQuoteId();
                        $collection = Mage::getModel('upload/upload')->getCurrentUploadedFiles($quote_id);
                        if ($_fileSizeCreate > (1024 * 1024 * $_fileSize)) {
                            $_flag = 1;
                            throw new Exception();
                        }
                        if (count($collection->getData()) >= $_maxNoFile) {
                            $_flag = 2;
                            throw new Exception();
                        }
                        $filetype = Mage::helper('upload')->checkFileType(pathinfo($_FILES[$type]['name'], PATHINFO_EXTENSION));
                        $arrData['file_upload_type'] = $filetype;
                        $uploader = new Varien_File_Uploader($type);
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setFilesDispersion(true);
                        $path = Mage::getBaseDir('media') . DS . 'uploads' . DS;
                        $uploader->save($path, $_FILES[$type]['name']);
                        $arrData['file_upload_path'] = $uploader->getUploadedFileName();
                        Mage::getSingleton('core/session')->setData($arrData);
                        Mage::getSingleton('core/session')->setFlag($flag);
                        $this->_redirect('checkout/cart');
                        //$message = $this->__($filetype . ' type file has been uploaded successfully.');
                        $message = $this->__('"'.$_FILES[$type]['name'] . '" has been uploaded successfully.');
                        Mage::getSingleton('core/session')->addSuccess($message);
                    } catch (Exception $e) {
                        if ($_flag == 1) {
                            $this->_redirect('checkout/cart');
                            Mage::getSingleton('core/session')->addError(Mage::helper('upload')->__("Maximum file size allowed is " . $_fileSize . " Mb"));
                        }
                        if ($_flag == 2) {
                            $this->_redirect('checkout/cart');
                            Mage::getSingleton('core/session')->addError(Mage::helper('upload')->__("Upload limit exceeds. You can upload maximum " . $_maxNoFile . " files"));
                        }
                        $this->_redirect('checkout/cart');
                        Mage::log($e->getMessage());
                    }
                } else {
                    $this->_redirect('checkout/cart');
                    $message = $this->__('Please choose file to upload.');
                    Mage::getSingleton('core/session')->addError($message);
                }
            }
        } else {
            $this->_redirect('checkout/cart');
            $message = $this->__('Cart is empty. Please add item to cart.');
            Mage::getSingleton('core/session')->addError($message);
        }
    }

    /**
     * file delete action
     */
    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $params = $this->getRequest()->getParams();
                $filename = $params["filename"];
                $filepath = str_replace('&', '/', $params["filepath"]);
                $model = Mage::getModel('upload/upload');
                $model->setId($this->getRequest()->getParam("id"))->delete();
                $path = Mage::getBaseDir('media') . DS . 'uploads' . $filepath;
                unlink($path);
                $this->_redirect("checkout/cart");
                Mage::getSingleton("core/session")->addSuccess(Mage::helper("upload")->__($filename . " removed successfully"));
            } catch (Exception $e) {
                $this->_redirect("checkout/cart");
                Mage::getSingleton("core/session")->addError("Opps..Some Error Occured...!!!");
                Mage::log($e->getMessage());
            }
        } else {
            $this->_redirect("checkout/cart");
        }
    }

    /**
     * multiple file delete action
     */
    public function massDeleteAction() {
        if ($this->getRequest()->getPost() && $this->getRequest()->getParam("files")) {
            try {
                $ids = $this->getRequest()->getPost('files', array());
                foreach ($ids as $id => $val) {
                    $model = Mage::getModel('upload/upload');
                    $model2 = Mage::getModel('upload/upload')->load($id);
                    $filepath = $model2->getData()['filename'];
                    $path = Mage::getBaseDir('media') . DS . 'uploads' . $filepath;
                    $model->setId($id)->delete();
                    unlink($path);
                }
                $this->_redirect("checkout/cart");
                Mage::getSingleton("core/session")->addSuccess(Mage::helper("upload")->__("Selected file(s) removed successfully"));
            } catch (Exception $e) {
                $this->_redirect("checkout/cart");
                Mage::getSingleton("core/session")->addError("Opps..Some Error Occured...!!!");
                Mage::log($e->getMessage());
            }
        } else {
            $this->_redirect("checkout/cart");
            $message = $this->__('Please choose files to remove.');
            Mage::getSingleton('core/session')->addError($message);
        }
    }

}
