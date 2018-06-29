<?php
namespace Bss\OrderDeliveryDate\Model\Plugin\Sales\Order\Email\Sender;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Container\OrderCommentIdentity;
use Magento\Sales\Model\Order\Email\Container\Template;
use Magento\Sales\Model\Order\Email\NotifySender;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Framework\Event\ManagerInterface;

class OrderCommentSender extends \Magento\Sales\Model\Order\Email\Sender\OrderCommentSender
{
    public function send(Order $order, $notify = true, $comment = '')
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $configLoader = $objectManager->get('Magento\Framework\ObjectManager\ConfigLoaderInterface');
        $objectManager->configure($configLoader->load('frontend'));
        $explode = explode("+",$comment);
        $tracing_number = $explode[0];
        $carrier_name = $explode[1];
        $transport = [
            'order' => $order,
            'tracing_number' => $tracing_number,
            'carrier_name' => $carrier_name,
            'billing' => $order->getBillingAddress(),
            'store' => $order->getStore(),
            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
            'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
            'shipping_arrival_date' => $order->getShippingArrivalDate(),
            'delivery_time_slot' => $order->getShippingArrivalTimeslot(),
             'shipping_delivered_date' => $order->getShippingDeliveredDate(),
            'shipping_arrival_comments' => $order->getShippingArrivalComments(),
        ];

        $this->eventManager->dispatch(
            'email_order_comment_set_template_vars_before',
            ['sender' => $this, 'transport' => $transport]
        );

        $this->templateContainer->setTemplateVars($transport);

        return $this->checkAndSend($order, $notify);
    }
}
