<?php

namespace App\Jobs\Webhook;

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
        logger('Webhook ok');
    }
}
