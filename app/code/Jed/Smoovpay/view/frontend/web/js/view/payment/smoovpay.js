define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'smoovpay',
                component: 'Jed_Smoovpay/js/view/payment/method-renderer/smoovpay-method'
            }
        );
        return Component.extend({});
    }
);