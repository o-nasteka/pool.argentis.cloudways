<?php

namespace App\Models\Lead;

use App\Services\KeyCrm\Leads\KeyCrmPrepareProducts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $this->prepareData($data);

        return self::create(
           LeadCollected::data(
               $this->name,
               $this->phone,
               $data,
               $this->products,
               $this->promocode,
               $this->delivery
           )
        );

    }

    /**
     * @param $data
     */
    private function prepareData($data)
    {
        $this->issetProducts = KeyCrmPrepareProducts::checkIssetProducts($data);

        $products = new KeyCrmPrepareProducts();
        $products->prepareProducts($data, $this->issetProducts);
        $this->products = $products;

        $leadHelper = new LeadHelper();
        $this->promocode = $leadHelper->preparePromocode($data,$this->issetProducts);
        $this->delivery = $leadHelper->prepareDelivery($data,$this->issetProducts);
        $this->name = $leadHelper->setName($data, $this->issetProducts);
        $this->phone = $leadHelper->setPhone($data, $this->issetProducts);
    }



}
