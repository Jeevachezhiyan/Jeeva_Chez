<?php
/**
* BSS Commerce Co.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://bsscommerce.com/Bss-Commerce-License.txt
*
* =================================================================
*                 MAGENTO EDITION USAGE NOTICE
* =================================================================
* This package designed for Magento COMMUNITY edition
* BSS Commerce does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* BSS Commerce does not provide extension support in case of
* incorrect edition usage.
* =================================================================
*
* @category   BSS
* @package    Bss_OrderDeliveryDate
* @author     Extension Team
* @copyright  Copyright (c) 2015-2016 BSS Commerce Co. ( http://bsscommerce.com )
* @license    http://bsscommerce.com/Bss-Commerce-License.txt
*/
namespace Bss\OrderDeliveryDate\Model\Plugin\Sales\Order\Email\Sender;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Container\ShipmentIdentity;
use Magento\Sales\Model\Order\Email\Container\Template;
use Magento\Sales\Model\Order\Email\Sender;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\ResourceModel\Order\Shipment as ShipmentResource;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Framework\Event\ManagerInterface;

class ShipmentSender extends \Magento\Sales\Model\Order\Email\Sender\ShipmentSender
{
    public function send(Shipment $shipment, $forceSyncMode = false, $comment)
    {
        $shipment->setSendEmail(true);
        $explode = explode("+",$comment);
        $tracing_number = $explode[0];
        $carrier_name = $explode[1];
        if (!$this->globalConfig->getValue('sales_email/general/async_sending') || $forceSyncMode) {
            $order = $shipment->getOrder(); 
            $transport = [
                'order' => $order,
                'shipment' => $shipment,
                'comment' => $shipment->getCustomerNoteNotify() ? $shipment->getCustomerNote() : '',
                'billing' => $order->getBillingAddress(),
                'payment_html' => $this->getPaymentHtml($order),
                'store' => $order->getStore(),
                'tracing_number' => $tracing_number,
                'carrier_name' => $carrier_name,
                'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
                'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
                'shipping_arrival_date' => $order->getShippingArrivalDate(),
                'delivery_time_slot' => $order->getShippingArrivalTimeslot(),
                'shipping_delivered_date' => $order->getShippingDeliveredDate(),
                'shipping_arrival_comments' => $order->getOrderComments(),
            ];

            $this->eventManager->dispatch(
                'email_shipment_set_template_vars_before',
                ['sender' => $this, 'transport' => $transport]
            );

            $this->templateContainer->setTemplateVars($transport);

            if ($this->checkAndSend($order)) {
                $shipment->setEmailSent(true);
                $this->shipmentResource->saveAttribute($shipment, ['send_email', 'email_sent']);
                return true;
            }
        }

        $this->shipmentResource->saveAttribute($shipment, 'send_email');

        return false;
    }
}
