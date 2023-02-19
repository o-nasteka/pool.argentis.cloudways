<?php


namespace App\Services\KeyCrm\Leads;

use App\Services\KeyCrm\Leads\KeyCrmInterface\PrepareProducts;
use Illuminate\Support\Facades\Log;

/**
 * Class KeyCrmPrepareProducts
 * @package App\Services\KeyCrm\Leads
 */
class KeyCrmPrepareProducts extends KeyCrmLeads implements PrepareProducts
{
    protected $products = [];

    public function __construct($data)
    {
        parent::__construct($data);
        $this->products = $data['payment']['products'];
        $this->prepareProducts();
    }

    /**
     * @param $data
     * @param $issetProducts
     * @return false|string
     */
    public function prepareProducts()
    {
        Log::channel('products')->info('***** Prepare DATA *****');
        Log::channel('products')->info($this->products);
        Log::channel('products')->info('***** Prepare DATA END *****');

        $this->productNameSpecialCharsDecode();
        json_encode($this->products);

        Log::channel('products')->info('***** Prepare products *****');
        Log::channel('products')->info($this->products);
        Log::channel('products')->info('***** Prepare products END *****');

        return $this->products;
    }


    /**
     *
     */
    public function productNameSpecialCharsDecode()
    {
        foreach ($this->products as &$dataPaymentProduct)
        {
            $dataPaymentProduct['name'] = htmlspecialchars_decode($dataPaymentProduct['name']);
        }

    }

    /**
     * @param $data
     * @return bool
     */
    public static function checkIssetProducts($data)
    {
        if (isset($data['payment'])){
            return true;
        }

        return false;
    }
}
