<?php

namespace Jed\Smoovpay\Block\Index;

class Redirect extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = [],\Magento\Framework\App\Request\Http $request)
    {
		$this->request = $request;
        
        parent::__construct($context, $data);

    }

    public function getIddata()
    {
        //return '000000019';
        return $this->request->getParam('id');
    }

    public function getBaseurl()
    {
        return  $this->_storeManager->getStore()->getBaseUrl();

    }

    public function getOrderdetails($data = null)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('\Magento\Sales\Model\Order') ->load($this->getIddata());
        $order_data = $order->getData();
        $data = $order_data[$data];
        return $data;
    }

    public function getMerchant()
    {
        $merchat_id = $this->_scopeConfig->getValue('payment/smoovpay/merchant'); 
        return $merchat_id;
    }

    public function getSignature()
    {
        $signature = $this->_scopeConfig->getValue('payment/smoovpay/secreat'); 
        return $signature;
    }

    public function getSignatureHash()
    {
        $dataToBeHashed = $this->getSignature()
                . $this->getMerchant()
                . 'pay'
                . $this->getOrderdetails('increment_id')
                . $this->getOrderdetails('grand_total')
                . $this->getOrderdetails('order_currency_code');;
        $utfString = mb_convert_encoding($dataToBeHashed, "UTF-8");
        $signature = sha1($utfString, false);
        return $signature;
    }

    public function getAllItems()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($this->getIddata());
        $orderItems = $order->getAllItems();
        $itemQty = array();
        foreach ($orderItems as $item) {
            $itemQty[]=array('quantity'=>$item->getQtyOrdered(),'description'=>$item->getDescription(),'name'=>$item->getName(),'price'=>$item->getPrice());
        }
        return $itemQty;
    }

}