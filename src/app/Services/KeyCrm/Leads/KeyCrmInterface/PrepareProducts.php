<?php


namespace App\Services\KeyCrm\Leads\KeyCrmInterface;


use App\Services\KeyCrm\Leads\KeyCrmPrepareProducts;

interface PrepareProducts
{
    function prepareProducts();

    function productNameSpecialCharsDecode();

    static function checkIssetProducts($data);
}
