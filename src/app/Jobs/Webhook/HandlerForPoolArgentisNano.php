<?php

namespace App\Jobs\Webhook;

use App\Http\Requests\StoreLeads;
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

    public function handle(StoreLeads $request)
    {
        logger('handle request: ', $request->all());

        $lead = Lead::create(($request->only(array_keys($request->rules()))));
        logger('lead:',$lead);

    }
}
