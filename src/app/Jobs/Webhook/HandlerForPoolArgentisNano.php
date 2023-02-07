<?php

namespace App\Jobs\Webhook;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class HandlerForPoolArgentisNano extends ProcessWebhookJob
{
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    public function handle(Request $request)
    {
//        logger('handle request: ', $this->request->all());
        Log::info('handle request: ', var_dump($request->all()));

//        $lead = Lead::create(($request->only(array_keys($request->rules()))));
//        logger('lead:',$request);

    }
}
