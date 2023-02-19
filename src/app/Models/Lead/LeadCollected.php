<?php


namespace App\Models\Lead;


/**
 * Class LeadCollected
 * @package App\Models\Lead
 */
class LeadCollected extends Lead
{
    /**
     * @param $name
     * @param $phone
     * @param $data
     * @param $products
     * @param $promocode
     * @param $delivery
     * @return mixed
     */
    protected static function data($name, $phone, $data, $products, $promocode, $delivery)
    {
        return [
            'name'                       =>      $name,
            'phone'                      =>      $phone,
            'email'                      =>      $data['email']                          ?? '',
            'checkbox'                   =>      $data['Checkbox']                       ?? '',
            'paymentsystem'              =>      $data['paymentsystem']                  ?? '',
            'payment_order_id'           =>      $data['payment']['orderid']             ?? '',
            'products'                   =>      $products                               ?? '',
            'promocode'                  =>      json_encode($promocode),
            'payment_subtotal'           =>      $data['payment']['subtotal']            ?? '',
            'payment_amount'             =>      $data['payment']['amount']              ?? '',
            'delivery'                   =>      json_encode($delivery),
            'form_id'                    =>      $data['formid']                         ?? '',
            'form_name'                  =>      $data['formname']                       ?? '',
        ];
    }
}
