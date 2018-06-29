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
namespace Bss\OrderDeliveryDate\Model\Plugin\Checkout;

class PaymentInformationManagementPlugin
{

	protected $orderFactory;
	const DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS = 2;

    public function __construct(
		\Magento\Sales\Model\OrderFactory $orderFactory,
		\Bss\OrderDeliveryDate\Helper\Data $helper
    ) {
		$this->orderFactory = $orderFactory;
		$this->_helper = $helper;
    }

    public function aroundSavePaymentInformationAndPlaceOrder(
		\Magento\Checkout\Model\PaymentInformationManagement $subject, 
		\Closure $proceed, $cartId,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {	
    	$request_body = file_get_contents('php://input');
		$data = json_decode($request_body, true);
		$orderId = $proceed($cartId, $paymentMethod, $billingAddress);
		if($this->_helper->isEnabled() && $this->_helper->getDisplayAt() == self::DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS){
			$order = $this->orderFactory->create()->load($orderId);
			if($data['paymentMethod']['additional_data']['date']){
				$order->setShippingArrivalDate($data['paymentMethod']['additional_data']['date']);
			}
			if($data['paymentMethod']['additional_data']['comments']){
				$order->setShippingArrivalComments($data['paymentMethod']['additional_data']['comments']);
			}
			if($data['paymentMethod']['additional_data']['timeslot']){
				$order->setShippingArrivalTimeslot($data['paymentMethod']['additional_data']['timeslot']);
			}
			$order->save();
		}
		return $orderId;
    }
}