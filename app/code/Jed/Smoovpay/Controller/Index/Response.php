<?php
/**
 * Copyright © 2015 Pay.nl All rights reserved.
 */

namespace Jed\Smoovpay\Controller\Index;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Model\OrderRepository;
use Paynl\Error\Error;

/**
 * Description of Redirect
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Response extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Paynl\Payment\Model\Config
     */
	private $config;

    /**
     * @var \Magento\Checkout\Model\Session
     */
	private $checkoutSession;

    /**
     * @var \Psr\Log\LoggerInterface
     */
	private $_logger;

    /**
     * @var PaymentHelper
     */
	private $paymentHelper;

	/**
	 * @var QuoteRepository
	 */
	private $quoteRepository;


	/**
	 * @var OrderRepository
	 */
	private $orderRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Paynl\Payment\Model\Config $config
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        
        \Magento\Checkout\Model\Session $checkoutSession,
        \Psr\Log\LoggerInterface $logger,
        PaymentHelper $paymentHelper,
		QuoteRepository $quoteRepository,
		OrderRepository $orderRepository,\Magento\Quote\Model\QuoteManagement $quoteManagement,\Magento\Quote\Model\QuoteFactory $quoteFactory
    )
    {
        //$this->config          = $config; // Pay.nl config helper
        $this->checkoutSession = $checkoutSession;
        $this->_logger         = $logger;
        $this->paymentHelper   = $paymentHelper;
		$this->quoteRepository = $quoteRepository;
		$this->orderRepository = $orderRepository;
		$this->quoteManagement = $quoteManagement;
		$this->quoteFactory = $quoteFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        try {
            
            /*if ($_SERVER["REQUEST_METHOD"]=="POST") {              
                $secret_key = $this->_scopeConfig->getValue('payment/smoovpay/secreat'); 
                $merchant = $_POST['merchant'];
                $ref_id = $_POST['ref_id']; 
                $reference_code = $_POST['reference_code']; 
                $response_code = $_POST['response_code']; 
                $currency = $_POST['currency'];
                $total_amount = $_POST['total_amount'];
                $signature = $_POST['signature'];
                $signature_algorithm = $_POST['signature_algorithm'];
                $dataToBeHashed = $secret_key
                                .$merchant
                                .$ref_id
                                .$reference_code
                                .$response_code
                                .$currency
                                .$total_amount;
                $utfString = mb_convert_encoding($dataToBeHashed, "UTF-8");
                $check_signature = sha1($utfString, false);
                if($response_code == 1)
                {
                    if ($signature == $check_signature) {
                       $order = $this->_getCheckoutSession()->getLastRealOrder();
                        $this->checkoutSession
                        ->setLastQuoteId($order->getQuoteId())
                        ->setLastSuccessQuoteId($order->getQuoteId())
                        ->clearHelperData();
                        if ($order) {
                            $this->checkoutSession->setLastOrderId($order->getId())
                                       ->setLastRealOrderId($order->getIncrementId())
                                       ->setLastOrderStatus('processing');
                        }            
                        return $this->_redirect('checkout/onepage/success');                
                    } else {
                            $e = 'Signature Not Matched';
                            $this->messageManager->addExceptionMessage($e, __('Something went wrong, please try again later'));
                            $this->_getCheckoutSession()->restoreQuote();
                            $this->_redirect('checkout/cart');
                    }

                }
                else{
                        $e = 'Payment Declined';
                        $this->messageManager->addExceptionMessage($e, __('Something went wrong, please try again later'));
                        $this->_getCheckoutSession()->restoreQuote();
                        $this->_redirect('checkout/cart');

                }
       
            }*/

            $order = $this->_getCheckoutSession()->getLastRealOrder();
            $this->checkoutSession
                    ->setLastQuoteId($order->getQuoteId())
                    ->setLastSuccessQuoteId($order->getQuoteId())
                    ->clearHelperData();
            	if ($order) {
                    $this->checkoutSession->setLastOrderId($order->getId())
                                       ->setLastRealOrderId($order->getIncrementId())
                                       ->setLastOrderStatus('processing');
                }            
                return $this->_redirect('checkout/onepage/success');
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong, please try again later'));
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
            $this->_logger->critical($e);
            $this->_getCheckoutSession()->restoreQuote();
            $this->_redirect('checkout/cart');
        }
    }

    /**
     * Return checkout session object
     *
     * @return \Magento\Checkout\Model\Session
     */
    protected function _getCheckoutSession()
    {
        return $this->checkoutSession;
    }
}