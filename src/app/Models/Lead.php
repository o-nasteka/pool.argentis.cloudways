<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $guarded = [''];

    public static function rules(): array
    {
        return [
            'name'                              => 'required|string|min:2|max:100',
            'phone'                             => 'required|string|min:2|max:100',
            'email'                             => 'sometimes|email|max:100',
            'checkbox'                          => 'sometimes|string|min:2|max:5',
            'paymentsystem'                     => 'sometimes|string|min:2|max:50',
            'payment_order_id'                  => 'sometimes|string|min:2|max:150',
            'payment_products_name'             => 'sometimes|string|min:2|max:255',
            'payment_products_quantity'         => 'sometimes|string|min:2|max:50',
            'payment_products_amount'           => 'sometimes|string|min:2|max:50',
            'payment_products_external_id'      => 'sometimes|string|min:2|max:255',
            'payment_products_price'            => 'sometimes|string|min:2|max:50',
            'payment_products_sku'              => 'sometimes|string|min:2|max:50',
            'promocode'                         => 'sometimes|string|min:2|max:50',
            'discountvalue'                     => 'sometimes|string|min:2|max:50',
            'discount'                          => 'sometimes|string|min:2|max:50',
            'subtotal'                          => 'sometimes|string|min:2|max:50',
            'amount'                            => 'sometimes|string|min:2|max:50',
            'delivery'                          => 'sometimes|string|min:2|max:255',
            'delivery_price'                    => 'sometimes|string|min:2|max:50',
            'delivery_fio'                      => 'sometimes|string|min:2|max:50',
            'delivery_address'                  => 'sometimes|string|min:2|max:255',
            'delivery_comment'                  => 'sometimes|string|min:2|max:255',
            'delivery_pickup_id'                => 'sometimes|string|min:2|max:50',
            'delivery_zip'                      => 'sometimes|string|min:2|max:50',
            'form_id'                           => 'sometimes|string|min:2|max:50',
            'form_name'                         => 'sometimes|string|min:2|max:50',
        ];
    }
}
