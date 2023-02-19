<?php


namespace App\Services\KeyCrm\Leads;


use App\Services\KeyCrm\KeyCrmService;

class KeyCrmLeads
{

    use KeyCrmService;

    /**
     * @var string
     */
    private string $actionName = 'Leads';

    /**
     * @var bool
     */
    private bool $issetProducts;

    /**
     * @var array
     */
    protected $products = [];

    /**
     * @var array
     */
    private $customFields = [];

    /**
     * KeyCrmLeads constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->issetProducts = KeyCrmPrepareProducts::checkIssetProducts($data);
        if ($this->issetProducts){
            $this->products = $data;
        }
    }

    /**
     * @param $data
     * @return KeyCrmSendLeadCallbak|array
     */
    public function prepareData()
    {
        if ($this->issetProducts){
            return $this->dataWithProduct($this->products);
        } else {
            $sendLeadCallback = new KeyCrmSendLeadCallbak();
            $sendLeadCallback->dataCallback($data);

            return $sendLeadCallback;
        }
    }

    /**
     * @param $data
     * @return array
     */
    private function dataWithProduct($data)
    {
        $products = new KeyCrmPrepareProducts($data);
        $this->products = $products->prepareProducts($data);

        $customFields = new KeyCrmCustomFields();
        $this->customFields = $customFields->prepareCustomFields($data);

        $collectedData = new KeyCrmCollected();
        return $collectedData->collectedData($data, $this->products, $this->customFields);

    }

    /**
     * @param $data_string
     */
    public function sendData($data_string)
    {
        $action     = config('services.keycrm.action_lead');
        KeyCrmService::sendData($data_string, $action, $this->actionName);
    }

}
