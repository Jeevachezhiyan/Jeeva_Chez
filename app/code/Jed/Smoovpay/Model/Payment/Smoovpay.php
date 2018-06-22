<?php


namespace Jed\Smoovpay\Model\Payment;

class Smoovpay extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = "smoovpay";
    protected $_isOffline = true;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        return parent::isAvailable($quote);
    }
}
