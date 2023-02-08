<?php

namespace App\Models;

use App\Http\Requests\LeadsRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $guarded = [''];

    public static function rules(): array
    {
        return [
            'name'                                      => 'required|string|min:2|max:100',
            'phone'                                     => 'required|string|min:2|max:100',
            'email'                                     => 'sometimes|email|max:100',
            'checkbox'                                  => 'sometimes|string|min:2|max:5',
            'paymentsystem'                             => 'sometimes|string|min:2|max:50',
            'payment_order_id'                          => 'sometimes|string|min:2|max:150',
            'payment_products_name'                     => 'sometimes|string|min:2|max:255',
            'payment_products_quantity'                 => 'sometimes|string|min:2|max:50',
            'payment_products_amount'                   => 'sometimes|string|min:2|max:50',
            'payment_products_external_id'              => 'sometimes|string|min:2|max:255',
            'payment_products_price'                    => 'sometimes|string|min:2|max:50',
            'payment_products_sku'                      => 'sometimes|string|min:2|max:50',
            'payment_promocode'                         => 'sometimes|string|min:2|max:50',
            'payment_discount_value'                    => 'sometimes|string|min:2|max:50',
            'payment_discount'                          => 'sometimes|string|min:2|max:50',
            'payment_subtotal'                          => 'sometimes|string|min:2|max:50',
            'payment_amount'                            => 'sometimes|string|min:2|max:50',
            'payment_delivery'                          => 'sometimes|string|min:2|max:255',
            'payment_delivery_price'                    => 'sometimes|string|min:2|max:50',
            'payment_delivery_fio'                      => 'sometimes|string|min:2|max:50',
            'payment_delivery_address'                  => 'sometimes|string|min:2|max:255',
            'payment_delivery_comment'                  => 'sometimes|string|min:2|max:255',
            'payment_delivery_pickup_id'                => 'sometimes|string|min:2|max:50',
            'payment_delivery_zip'                      => 'sometimes|string|min:2|max:50',
            'form_id'                                   => 'sometimes|string|min:2|max:50',
            'form_name'                                 => 'sometimes|string|min:2|max:50',
        ];
    }

    /**
     * @param $data
     */
    public static function store($data)
    {
        Log::info('store: ', $data);
        return self::create([
            'name'                                      =>      $data['name'],
            'phone'                                     =>      $data['phone'],
            'email'                                     =>      $data['email'],
            'checkbox'                                  =>      $data['Checkbox'],
            'paymentsystem'                             =>      $data['paymentsystem'],
            'payment_order_id'                          =>      $data['payment']['orderid'],
            'payment_products_name'                     =>      $data['payment']['products']['name'],
            'payment_products_quantity'                 =>      $data['payment']['products']['quantity'],
            'payment_products_amount'                   =>      $data['payment']['products']['amount'],
            'payment_products_external_id'              =>      $data['payment']['products']['externalid'],
            'payment_products_price'                    =>      $data['payment']['products']['price'],
            'payment_products_sku'                      =>      $data['payment']['products']['sku'],
            'payment_promocode'                         =>      $data['payment']['promocode'],
            'payment_discount_value'                    =>      $data['payment']['discountvalue'],
            'payment_discount'                          =>      $data['payment']['discount'],
            'payment_subtotal'                          =>      $data['payment']['subtotal'],
            'payment_amount'                            =>      $data['payment']['amount'],
            'payment_delivery'                          =>      $data['payment']['delivery'],
            'payment_delivery_price'                    =>      $data['payment']['delivery_price'],
            'payment_delivery_fio'                      =>      $data['payment']['delivery_fio'],
            'payment_delivery_address'                  =>      $data['payment']['delivery_address'],
            'payment_delivery_comment'                  =>      $data['payment']['delivery_comment'],
            'payment_delivery_pickup_id'                =>      $data['payment']['delivery_pickup_id'],
            'payment_delivery_zip'                      =>      $data['payment']['delivery_zip'],
            'form_id'                                   =>      $data['formid'],
            'form_name'                                 =>      $data['formname'],
        ]);
    }
}
