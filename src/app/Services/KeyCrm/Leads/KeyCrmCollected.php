<?php


namespace App\Services\KeyCrm\Leads;


class KeyCrmCollected
{
    public function collectedData($data, $products, $customFields)
    {
        return $preparedData = [
            "title"             => '',
            "source_id"         => 1,
            "manager_comment"   => '',
            "manager_id"        => 1,
            "pipeline_id"       => '',
            "contact" => [
                "full_name"     => $data['name']            ?? '',
                "phone"         => $data['phone']           ?? '',
                "email"         => $data['email']           ?? '',
            ],
            "utm_source"        => $data['utm_source']      ?? '-',
            "utm_medium"        => $data['utm_medium']      ?? '-',
            "utm_campaign"      => $data['utm_campaign']    ?? '-',
            "utm_term"          => $data['utm_term']        ?? '-',
            "utm_content"       => $data['utm_content']     ?? '-',
            "products"          => $products                ?? '',
            "custom_fields"     => $customFields            ?? '',
        ];
    }
}
