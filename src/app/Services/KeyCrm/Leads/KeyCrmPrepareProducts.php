<?php


namespace App\Services\KeyCrm\Leads;

use Illuminate\Support\Facades\Log;

/**
 * Class KeyCrmPrepareProducts
 * @package App\Services\KeyCrm\Leads
 */
class KeyCrmPrepareProducts
{

    /**
     * @param $data
     * @param $issetProducts
     * @return false|string
     */
    public function prepareProducts($data, $issetProducts)
    {
        if($issetProducts){
            $products = $this->prepareDataProductsName($data['payment']['products']);
            $products = json_encode($products);
        }

        Log::channel('products')->info('***** Prepare products *****');
        Log::channel('products')->info(var_dump($products));
        Log::channel('products')->info('***** Prepare products END *****');

        Log::channel('products')->info('***** Type of products *****');
        Log::channel('products')->info(gettype($products));
        Log::channel('products')->info('***** Type of products END *****');

        return  $products ;
    }

    /**
     * @param $dataPaymentProducts
     * @return mixed
     */
    private function prepareDataProductsName($dataPaymentProducts)
    {
        $dataPaymentProducts = $this->productNameSpecialCharsDecode($dataPaymentProducts);

        return $dataPaymentProducts;
    }

    /**
     * @param $dataPaymentProducts
     * @return mixed
     */
    private function productNameSpecialCharsDecode($dataPaymentProducts)
    {
        foreach ($dataPaymentProducts as &$dataPaymentProduct)
        {
            $dataPaymentProduct['name'] = htmlspecialchars_decode($dataPaymentProduct['name']);
        }

        return $dataPaymentProducts;
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
