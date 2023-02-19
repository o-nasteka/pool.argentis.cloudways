<?php


namespace App\Models\Lead;


class LeadHelper extends Lead
{
    /**
     * @param $data
     */
    protected function preparePromocode($data, $issetProducts)
    {
        if($this->$issetProducts){
            return [
                'promocode'       =>   $data['payment']['promocode']      ?? '',
                'discountvalue'   =>   $data['payment']['discountvalue']  ?? '',
                'discount'        =>   $data['payment']['discountvalue']  ?? '',
            ];
        }
        return [];
    }

    /**
     * @param $data
     */
    protected function prepareDelivery($data, $issetProducts)
    {
        if($issetProducts){
            return [
                'delivery'                      =>   $data['payment']['delivery']               ?? '',
                'delivery_price'                =>   $data['payment']['delivery_price']         ?? '',
                'delivery_fio'                  =>   $data['payment']['delivery_fio']           ?? '',
                'delivery_address'              =>   $data['payment']['delivery_address']       ?? '',
                'delivery_comment'              =>   $data['payment']['delivery_comment']       ?? '',
                'delivery_pickup_id'            =>   $data['payment']['delivery_pickup_id']     ?? '',
                'delivery_zip'                  =>   $data['payment']['delivery_zip']           ?? '',
            ];
        }

        return [];
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function setName($data, $issetProducts)
    {
        if($issetProducts){
            return $data['name'];
        }

        return $data['Name'];
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function setPhone($data, $issetProducts)
    {
        if($issetProducts){
            return $data['phone'];
        }

        return $data['Phone'];
    }

}
