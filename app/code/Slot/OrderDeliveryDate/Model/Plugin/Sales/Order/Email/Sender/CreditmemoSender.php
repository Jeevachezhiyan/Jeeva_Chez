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
use Magento\Sales\Model\Order\Creditmemo;
use Magento\Sales\Model\Order\Email\Container\CreditmemoIdentity;
use Magento\Sales\Model\Order\Email\Container\Template;
use Magento\Sales\Model\Order\Email\Sender;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo as CreditmemoResource;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Framework\Event\ManagerInterface;

class CreditmemoSender extends \Magento\Sales\Model\Order\Email\Sender\CreditmemoSender
{
    public function send(Order $order, $notify = true, $comment = '')
    {

        if (!$this->globalConfig->getValue('sales_email/general/async_sending') || $forceSyncMode) {
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
                'email_creditmemo_set_template_vars_before',
                ['sender' => $this, 'transport' => $transport]
            );

            $this->templateContainer->setTemplateVars($transport);

            if ($this->checkAndSend($order)) {
                $creditmemo->setEmailSent(true);
                $this->creditmemoResource->saveAttribute($creditmemo, ['send_email', 'email_sent']);
                return true;
            }
        }

        $this->creditmemoResource->saveAttribute($creditmemo, 'send_email');

        return false;
    }
}
