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
namespace Bss\OrderDeliveryDate\Block\Plugin\Checkout;

class LayoutProcessorPlugin
{
    protected $_helper;
    const DELIVERY_FORM_DISPLAY_AT_SHIPPING_ADDRESS = 0;
    const DELIVERY_FORM_DISPLAY_AT_SHIPPING_METHOD = 1;
    const DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS = 2;

    public function __construct(
        \Bss\OrderDeliveryDate\Helper\Data $helper
        ) {
        $this->_helper = $helper;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $container = null;
        if(!$this->_helper->isEnabled()) return $jsLayout;
        if($this->_helper->getDisplayAt() == self::DELIVERY_FORM_DISPLAY_AT_SHIPPING_ADDRESS) {
            $container = 'shipping-address-fieldset';
        } elseif($this->_helper->getDisplayAt() == self::DELIVERY_FORM_DISPLAY_AT_SHIPPING_METHOD) {
            $container = 'before-shipping-method-form';
        }
        $dateFormat = $this->_helper->getDateFormat();


        // before place order
        if($this->_helper->getDisplayAt() == self::DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS){
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children']['before-place-order']['children']['shipping_arrival_date'] = [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/date',
                    'options' => [
                        // 'appendText' => 'Select Date',
                        'dateFormat' => $dateFormat,
                    ],
                    // 'disabled' => true,
                    'id' => 'shipping-arrival-date',
                    'class' => 'test'
                ],
                'dataScope' => 'shippingAddress.shipping_arrival_date',
                'label' => 'Delivery Date',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 201,
                'id' => 'shipping-arrival-date'
            ];
        }else{
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children'][$container]['children']['shipping_arrival_date'] = [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/date',
                    'options' => [
                        'dateFormat' => $dateFormat,
                    ],
                    // 'disabled' => true,
                    'id' => 'shipping-arrival-date'
                ],
                'dataScope' => 'shippingAddress.shipping_arrival_date',
                'label' => 'Delivery Date',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 201,
                'id' => 'shipping-arrival-date'
            ];
        }



    $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
           ['shippingAddress']['children'][$container]['children']['order_comments'] = [



                'component' => 'Magento_Ui/js/form/element/textarea',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/textarea',
                    'id' => 'order-comments',
                    'rows' => 2
                ],
                'dataScope' => 'shippingAddress.order_comments',
                'label' => 'Order Comments',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 200,
                'id' => 'order-comments'
            ];


$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
           ['shippingAddress']['children'][$container]['children']['delivery_time_slot'] = [

                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                    'id' => 'delivery-time-slot',
                    'rows' => 1
                ],
                'dataScope' => 'shippingAddress.delivery_time_slot',
                'label' => 'WBS#',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 190,
                'id' => 'delivery-time-slot'
            ];

        




        // if($this->_helper->getTimeSlot()){
        //     // before place order
        //     if($this->_helper->getDisplayAt() == self::DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS){
        //         $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        //     ['payment']['children']['payments-list']['children']['before-place-order']['children']['delivery_time_slot'] = [
        //             'component' => 'Magento_Ui/js/form/element/select',
        //             'config' => [
        //                 'customScope' => 'shippingAddress',
        //                 'template' => 'ui/form/field',
        //                 'elementTmpl' => 'ui/form/element/select',
        //                 'id' => 'delivery-time-slot'
        //             ],
        //             'caption' => 'Please select delivery time slot',
        //             'dataScope' => 'shippingAddress.delivery_time_slot',
        //             'label' => 'Delivery Time Slot',
        //             'provider' => 'checkoutProvider',
        //             'visible' => true,
        //             'validation' => [],
        //             'options' => $this->_helper->getTimeSlot(),
        //             'sortOrder' => 202,
        //             'id' => 'delivery-time-slot',
        //         ];
        //     }else{
        //         $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        //         ['shippingAddress']['children'][$container]['children']['delivery_time_slot'] = [
        //             'component' => 'Magento_Ui/js/form/element/select',
        //             'config' => [
        //                 'customScope' => 'shippingAddress',
        //                 'template' => 'ui/form/field',
        //                 'elementTmpl' => 'ui/form/element/select',
        //                 'id' => 'delivery-time-slot'
        //             ],
        //             'caption' => 'Please select delivery time slot',
        //             'dataScope' => 'shippingAddress.delivery_time_slot',
        //             'label' => 'Delivery Time Slot',
        //             'provider' => 'checkoutProvider',
        //             'visible' => true,
        //             'validation' => [],
        //             'options' => $this->_helper->getTimeSlot(),
        //             'sortOrder' => 202,
        //             'id' => 'delivery-time-slot',
        //         ];
        //     }
        // }
        // before place order
        if($this->_helper->getDisplayAt() == self::DELIVERY_FORM_DISPLAY_AT_REVIEW_PAYMENTS){
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children']['before-place-order']['children']['shipping_arrival_comments'] = [
                'component' => 'Magento_Ui/js/form/element/textarea',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/textarea',
                    'id' => 'shipping-arrival-comments',
                    'rows' => 25
                ],
                'dataScope' => 'shippingAddress.shipping_arrival_comments',
                'label' => 'Rush Order Comments',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 202,
                'id' => 'shipping-arrival-comments'
            ];
        }else{
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children'][$container]['children']['shipping_arrival_comments'] = [
                'component' => 'Magento_Ui/js/form/element/textarea',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/textarea',
                    'id' => 'shipping-arrival-comments',
                    'rows' => 5,

                ],
                'dataScope' => 'shippingAddress.shipping_arrival_comments',
                'label' => 'Rush Order Comments',
                'provider' => 'checkoutProvider',
                'visible' => false,
                'validation' => [],
                 
                'sortOrder' => 202,
                'id' => 'shipping-arrival-comments'
            ];
        }
        return $jsLayout;
    }
}
