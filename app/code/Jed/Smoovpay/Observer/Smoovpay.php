<?php
namespace Jed\Smoovpay\Observer;
use Magento\Sales\Model\Order;

class Smoovpay implements \Magento\Framework\Event\ObserverInterface
{

  public function __construct(
        \Magento\Framework\Registry $registry, \Magento\Framework\App\Action\Context $context,\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Checkout\Model\Session $checkoutSession)
    {

        $this->_storeManager = $storeManager;
        $this->checkoutSession = $checkoutSession;
        $this->registry = $registry;
    }

  public function execute(\Magento\Framework\Event\Observer $observer)
    { 
        $orderId = $observer->getEvent()->getOrderIds();
        $base_url = $this->_storeManager->getStore()->getBaseUrl();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('\Magento\Sales\Model\Order') ->load($orderId[0]);
        $payment = $order->getPayment();

        
        $method = $payment->getMethodInstance();
        $methodTitle = $method->getTitle();
     
        $order_data= $order->getData();
        $status = $this->checkoutSession->getLastOrderStatus();

        if($status == 'processing' && $methodTitle == 'Smoovpay'){
            $orderState = \Magento\Sales\Model\Order::STATE_PROCESSING;
            $order->setState($orderState)->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING);
            $order->save();
            return true;
        }
        else if($status == 'pending' && $methodTitle == 'Smoovpay'){
          $increment_id = $order_data['increment_id'];
          $redirect = $objectManager->get('\Magento\Framework\App\Response\Http');
          $redirect->setRedirect($base_url.'smoovpay/index/redirect/id/'.$increment_id.'');
          return;
        }
        else{
          return true;
        } 
    }
}
