<?php

namespace App\Webhook;

use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use App\Services\KeyCrm\KeyCrmLeads;

class HandlerForPoolArgentisNano extends ProcessWebhookJob
{


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

    /**
     *
     */
    public function handle()
    {
        if(config('services.keycrm.service_enabled')){
            $data = $this->webhookCall['payload'];
            if(config('services.keycrm.log')) {
                Log::channel('keycrm')->info('**** Webhook data ****');
                Log::channel('keycrm')->info($data);
                Log::channel('keycrm')->info('**** Webhook data END ****');
            }

            $keyCrmLeads = new KeyCrmLeads();
            $preparedData = $keyCrmLeads->prepareData($data);

            if(config('services.keycrm.log')) {
                Log::channel('keycrm')->info('*** Prepared data ***');
                Log::channel('keycrm')->info($preparedData);
                Log::channel('keycrm')->info('*** Prepared data END ***');
            }

            if ($preparedData){
                $keyCrmLeads->sendData(json_encode($preparedData));
            } else {
                Log::channel('keycrm')->info('*** Data is null ***');
            }
        }

    }


}
