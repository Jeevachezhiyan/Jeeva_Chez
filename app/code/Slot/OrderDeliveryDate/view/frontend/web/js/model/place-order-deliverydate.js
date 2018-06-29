define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(placeOrderAction, function(originalAction, paymentData, redirectOnSuccess, messageContainer) {
            var order_comments=jQuery('[name="shippingAddress[shipping_arrival_comments]"]').val();
            var order_date=jQuery('[name="shippingAddress[shipping_arrival_date]"]').val();
            var order_time_slot = '';
            if(jQuery('[name="shippingAddress[delivery_time_slot]"]').val()) order_time_slot=jQuery('[name="shippingAddress[delivery_time_slot]"]').val();
            paymentData.additional_data = {date:order_date,comments:order_comments,timeslot:order_time_slot};
            return originalAction(paymentData, redirectOnSuccess, messageContainer);
        });
    };
});