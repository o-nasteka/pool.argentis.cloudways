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
    private $issetProducts = false;

    /**
     * @var array
     */
    private $products = [];


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

    /**
     * @param $data
     */
    public function store($data)
    {
        Log::channel('keycrm')->info('*** Leads ***');
        Log::channel('keycrm')->info($data);
        Log::channel('keycrm')->info('*** Leads END ***');

        $this->prepareData($data);


        return self::create([
            'name'                       =>      $this->name,
            'phone'                      =>      $this->phone,
            'email'                      =>      $data['email']                                     ?? '',
            'checkbox'                   =>      $data['Checkbox']                                  ?? '',
            'paymentsystem'              =>      $data['paymentsystem']                             ?? '',
            'payment_order_id'           =>      $data['payment']['orderid']                        ?? '',
            'products'                   =>      $this->products                                    ?? '',
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
    private function prepareData($data)
    {
        $this->checkIssetProducts($data);
        $this->prepareProducts($data);
        $this->preparePromocode($data);
        $this->prepareDelivery($data);
        $this->setName($data);
        $this->setPhone($data);
    }

    /**
     * @param $data
     */
    private function checkIssetProducts($data)
    {
        if (isset($data['payment'])){
            $this->issetProducts = true;
        }
    }

    /**
     * @param $data
     */
    private function prepareProducts($data)
    {
        if($this->issetProducts){
            $this->products = json_encode($data['payment']['products']);
        }
    }

    /**
     * @param $data
     */
    private function preparePromocode($data)
    {
        if($this->issetProducts){
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
        if($this->issetProducts){
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
        if($this->issetProducts){
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
        if($this->issetProducts){
            return $this->phone = $data['phone'];
        }

        return $this->phone = $data['Phone'];
    }


}
