<?php

namespace App\Webhook;

use App\Jobs\CreateLead;
use App\Models\Lead\Lead;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use App\Services\KeyCrm\Leads\KeyCrmLeads;

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
                Log::channel('webhook')->info('**** Webhook data ****');
                Log::channel('webhook')->info($data);
                Log::channel('webhook')->info('**** Webhook data END ****');
            }

            $keyCrmLeads = new KeyCrmLeads($data);
            $preparedData = $keyCrmLeads->prepareData($data);

            // Store Lead
            CreateLead::dispatch($data);

            if(config('services.keycrm.log')) {
                Log::channel('keycrm')->info('*** Prepared data for KeyCrm ***');
                Log::channel('keycrm')->info($preparedData);
                Log::channel('keycrm')->info('*** Prepared data for KeyCrm END ***');
            }

            // Send data to KeyCrm
            if ($preparedData){
                $keyCrmLeads->sendData(json_encode($preparedData));
            } else {
                Log::channel('keycrm')->info('*** Data is null ***');
            }
        }

    }


}
