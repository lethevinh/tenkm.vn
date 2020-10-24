<?php

namespace Omnipay\Payoo;

use Omnipay\Omnipay;

class Payoo
{
    /**
     * @return mixed
     */
    public function gateway()
    {
        $gateway = Omnipay::create('Payoo');
        $configs = config('payment.gateways.Payoo');
        $gateway->initialize($configs);
        return $gateway;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function purchase(array $parameters)
    {
        return $this->gateway()
            ->purchase($parameters)
            ->send();
    }

    /**
     * @param array $parameters
     */
    public function complete(array $parameters)
    {
        return $this->gateway()
            ->completePurchase($parameters)
            ->send();
    }


    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function getCancelUrl($order)
    {
        return route('payment.checkout.cancelled', ['order' => $order->transaction_id, 'gateway' => 'payoo']);
    }

    public function getReturnUrl($order)
    {
        return route('payment.checkout.completed', ['order' => $order->transaction_id, 'gateway' => 'payoo']);
    }

    public function getNotifyUrl($order)
    {
        $env = config('services.paypal.sandbox') ? "sandbox" : "live";

        return route('webhook.paypal.ipn', [$order->transaction_id, $env]);
    }
}
