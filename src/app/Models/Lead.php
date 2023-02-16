<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class Lead
 * @package App\Models
 */
class Lead extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'leads';

    /**
     * @var string[]
     */
    protected $guarded = [''];

    /**
     * @var string
     */
    protected string $name = '';

    /**
     * @var string
     */
    protected string $phone = '';

    /**
     * @var bool
     */
    private $dataProducts = false;


    /**
     * @var array
     */
    private $promocode = [];

    /**
     * @var array
     */
    private $delivery = [];

    /**
     * @var string[]
     */
    protected $casts = [
        'products'  => 'array',
        'promocode' => 'array',
        'delivery'  => 'array',
    ];

//    /**
//     * @param $value
//     */
//    public function setProductsAttribute($value)
//    {
//        if (is_string($value)) {
//            $value = json_decode($value, true);
//        }
//        if (empty($value)) {
//            $value = array();
//        }
//        $this->attributes['products'] = json_encode($value);
//    }
//
//    /**
//     * @param $value
//     */
//    public function setPromocodeAttribute($value)
//    {
//        if (is_string($value)) {
//            $value = json_decode($value, true);
//        }
//        if (empty($value)) {
//            $value = array();
//        }
//        $this->attributes['promocode'] = json_encode($value);
//    }
//
//    /**
//     * @param $value
//     */
//    public function setDeliveryAttribute($value)
//    {
//        if (is_string($value)) {
//            $value = json_decode($value, true);
//        }
//        if (empty($value)) {
//            $value = array();
//        }
//        $this->attributes['delivery'] = json_encode($value);
//    }

    /**
     * @param $data
     */
    public function store($data)
    {
        Log::channel('keycrm')->info('*** Leads ***');
        Log::channel('keycrm')->info($data);
        Log::channel('keycrm')->info('*** Leads END ***');

        $this->checkDataProducts($data);
        $this->preparePromocode($data);
        $this->prepareDelivery($data);
        $this->setName($data);
        $this->setPhone($data);

        return self::create([
            'name'                       =>      $this->name,
            'phone'                      =>      $this->phone,
            'email'                      =>      $data['email']                                     ?? '',
            'checkbox'                   =>      $data['Checkbox']                                  ?? '',
            'paymentsystem'              =>      $data['paymentsystem']                             ?? '',
            'payment_order_id'           =>      $data['payment']['orderid']                        ?? '',
            'products'                   =>      json_encode($data['payment']['products'])          ?? '',
            'promocode'                  =>      json_encode($this->promocode),
            'payment_subtotal'           =>      $data['payment']['subtotal']                       ?? '',
            'payment_amount'             =>      $data['payment']['amount']                         ?? '',
            'delivery'                   =>      json_encode($this->delivery),
            'form_id'                    =>      $data['formid']                                    ?? '',
            'form_name'                  =>      $data['formname']                                  ?? '',
        ]);
    }

    /**
     * @param $data
     */
    public function checkDataProducts($data)
    {
        if (isset($data['payment'])){
            $this->dataProducts = true;
        }
    }

    /**
     * @param $data
     */
    private function preparePromocode($data)
    {
        if($this->dataProducts){
            $this->promocode = [
              'promocode'       =>   $data['payment']['promocode']      ?? '',
              'discountvalue'   =>   $data['payment']['discountvalue']  ?? '',
              'discount'        =>   $data['payment']['discountvalue']  ?? '',
            ];
        }

    }

    /**
     * @param $data
     */
    private function prepareDelivery($data)
    {
        if($this->dataProducts){
            $this->delivery = [
                'delivery'                      =>   $data['payment']['delivery']               ?? '',
                'delivery_price'                =>   $data['payment']['delivery_price']         ?? '',
                'delivery_fio'                  =>   $data['payment']['delivery_fio']           ?? '',
                'delivery_address'              =>   $data['payment']['delivery_address']       ?? '',
                'delivery_comment'              =>   $data['payment']['delivery_comment']       ?? '',
                'delivery_pickup_id'            =>   $data['payment']['delivery_pickup_id']     ?? '',
                'delivery_zip'                  =>   $data['payment']['delivery_zip']           ?? '',
            ];
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    private function setName($data)
    {
        if($this->dataProducts){
            return $this->name = $data['name'];
        }

        return $this->name = $data['Name'];
    }

    /**
     * @param $data
     * @return mixed
     */
    private function setPhone($data)
    {
        if($this->dataProducts){
            return $this->phone = $data['phone'];
        }

        return $this->phone = $data['Phone'];
    }


}
