<?php

namespace App\Handler;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Illuminate\Support\Facades\Log;

class WebhookJobHandlerForPoolArgentisNano extends ProcessWebhookJob
{
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    public function handle()
    {
//        Log::info("Request Captured", $request->all());
        Log::info("Webhook ok");
//        dump('webhook ok');
        //You can perform an heavy logic here
//        logger($this->webhookCall);
//        sleep(10);
//        logger("I am done");
    }
}
