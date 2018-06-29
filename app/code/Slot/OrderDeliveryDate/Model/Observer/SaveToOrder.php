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
namespace Bss\OrderDeliveryDate\Model\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
/**
 * Visitor Observer
 */
class SaveToOrder implements ObserverInterface
{
     protected $_objectManager;
     protected $_helper;
     const DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS = 2;
    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager,\Bss\OrderDeliveryDate\Helper\Data $helper)
    {
        $this->_helper = $helper;
        $this->_objectManager = $objectmanager;
    }

    public function execute(EventObserver $observer)
    {
      if($this->_helper->isEnabled() && $this->_helper->getDisplayAt() != self::DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS){
        $order = $observer->getOrder();
        $quoteRepository = $this->_objectManager->create('Magento\Quote\Model\QuoteRepository');
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $quoteRepository->get($order->getQuoteId());
        $order->setShippingArrivalDate($quote->getShippingArrivalDate())
              ->setShippingArrivalTimeslot($quote->getShippingArrivalTimeslot())
              ->setShippingArrivalComments($quote->getShippingArrivalComments())
	      ->setOrderComments($quote->getOrderComments())
              ->setTraceNumber($quote->getTraceNumber());

        return $this;
      }
    }

}
