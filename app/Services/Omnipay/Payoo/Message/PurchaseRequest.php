<?php

namespace Omnipay\Payoo\Message;

use Illuminate\Support\Carbon;
use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    const RULE_DES_MIN_LENGTH = 50;

    const TIME_ZONE = 'Asia/Ho_Chi_Minh';

    public function getData()
    {
        $this->validate(
            'apiUsername',
            'businessUsername',
            'secretKey',
            'shopId',
            'shopTitle',
            'shopDomain',
            'transactionId',
            'returnUrl',
            'notifyUrl',
            'amount',
            'description'
        );

        try {
            $this->guardDescription();
        } catch (InvalidRequestException $e) {
        }

        $orderXml = $this->buildOrderXml();

        $secretKey = $this->getSecretKey();

        return [
            'bc' => '',
            'pm' => '',
            'OrdersForPayoo' => $orderXml,
            'CheckSum' => hash('sha512', $secretKey . $orderXml),
        ];
    }

    public function sendData($data)
    {
        return new PurchaseResponse($this, $data);
    }

    protected function buildOrderXml()
    {
        $orderShipDate = Carbon::now()->addDay(1)->format('d/m/Y');
        $validityTime =  date('YmdHis', strtotime('+1 day', time()));
        return '<shops><shop>' .
            '<session>' . $this->getTransactionId() . '</session>' .
            '<username>' . $this->getBusinessUsername() . '</username>' .
            '<shop_id>' . $this->getShopId() . '</shop_id>' .
            '<shop_title>' . $this->getShopTitle() . '</shop_title>' .
            '<shop_domain>' . $this->getShopDomain() . '</shop_domain>' .
            '<shop_back_url>' . $this->getReturnUrl() . '</shop_back_url>' .
            '<order_no>' . $this->getTransactionId() . '</order_no>' .
            '<order_cash_amount>' . $this->getAmountInteger() . '</order_cash_amount>' .
            '<order_ship_date>' . $orderShipDate . '</order_ship_date>' .
            '<order_ship_days>' . 0 . '</order_ship_days>' .
            '<order_description>' . urlencode($this->getDescription()) . '</order_description>' .
            '<validity_time>' . $validityTime . '</validity_time>' .
            '<notify_url>' . $this->getNotifyUrl() . '</notify_url>' .
            '<customer>' .
            '<name>' . $this->getCard()->getName() . '</name>' .
            '<phone>' . $this->getCard()->getNumber() . '</phone>' .
            '<address>' . $this->getCard()->getAddress2() . '</address>' .
            '<city>' . $this->getCard()->getCity() . '</city>' .
            '<email>' . $this->getCard()->getEmail() . '</email>' .
            '</customer>' .
            '</shop></shops>';
    }

    private function guardDescription()
    {
        if (strlen($this->getDescription()) <= self::RULE_DES_MIN_LENGTH) {
            throw new InvalidRequestException("The description parameter must be larger than 50 characters");
        }
    }


}
