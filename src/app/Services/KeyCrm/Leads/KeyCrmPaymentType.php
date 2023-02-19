<?php


namespace App\Services\KeyCrm\Leads;


class KeyCrmPaymentType
{
    private static $paymentSystem = [
        'cash'      => 'Післяплата',
        'monobank'  => 'Monobank'
    ];

    /**
     * @param $paymentSystem
     * @return string
     */
    public static function setPaymentType($paymentSystem)
    {
        switch ($paymentSystem){
            case 'cash':
                $paymentSystem = self::$paymentSystem['cash'];
                break;
            case 'custom.monobank':
                $paymentSystem = self::$paymentSystem['monobank'];
                break;
        }

        return $paymentSystem;
    }
}
