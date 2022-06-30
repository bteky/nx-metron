<?php



namespace App\Services;

use App\Services\Gateway\{
    AopF2F,
    Codepay,
    PaymentWall,
    SPay,
    PAYJS,
    YftPay,
    BitPayX,
    MetronPay,
    WellPay
};

class Payment
{
    public static function getClient($request = null, $response = null, $args = null)
    {
        $method = $_ENV['payment_system'];
        switch ($method) {
            case ('codepay'):
                return new Codepay();
            case ('paymentwall'):
                return new PaymentWall();
            case ('spay'):
                return new SPay();
            case ('f2fpay'):
                return new AopF2F();
            case ('payjs'):
                return new PAYJS($_ENV['payjs_key']);
            case ('yftpay'):
                return new YftPay();
            case ('bitpayx'):
                return new BitPayX($_ENV['bitpay_secret']);
            case("metronpay"):
                return new MetronPay();
            case ("wellpay"):
                return new WellPay($_ENV['wellpay_app_secret']);
            default:
                return null;
        }
    }

    public static function notify($request, $response, $args)
    {
        return self::getClient()->notify($request, $response, $args);
    }
    public function test(){
        echo 123;
    }

    public static function returnHTML($request, $response, $args)
    {
       
        return self::getClient()->getReturnHTML($request, $response, $args);
    }

    public static function purchaseHTML()
    {
        if (self::getClient() != null) {
            return self::getClient()->getPurchaseHTML();
        }

        return '';
    }

    public static function getStatus($request, $response, $args)
    {
        return self::getClient()->getStatus($request, $response, $args);
    }

    public static function purchase($request, $response, $args)
    {
        
        return self::getClient($request, $response, $args)->purchase($request, $response, $args);
    }
}
