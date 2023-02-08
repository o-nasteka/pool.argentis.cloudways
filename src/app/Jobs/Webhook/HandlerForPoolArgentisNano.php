<?php

namespace App\Jobs\Webhook;

use App\Models\Lead;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class HandlerForPoolArgentisNano extends ProcessWebhookJob
{

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;


    public function handle()
    {
        $data = json_decode($this->webhookCall, true)['payload'];
        logger($data);
    }
}
