<?php
namespace App\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class PromocodeFieldHandler extends AbstractHandler
{
    protected $codename = 'promocode';
    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('vendor.voyager.formfields.promocode', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
