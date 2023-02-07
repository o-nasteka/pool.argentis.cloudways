<?php

return [
    'configs' => [
        [
            'name' => 'webhook-pool-argentisnano',
            'signing_secret' => env('WEBHOOK_CLIENT_SECRET_FOR_POOL_ARGENTISNANO'),
            'signature_header_name' => 'X-signature-pool-argentisnano',
            'signature_validator' => \App\Jobs\Webhook\ArgentisNanoValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => \App\Jobs\Webhook\HandlerForPoolArgentisNano::class,
        ],
//        [
//            'name' => 'webhook-sending-app-2',
//            'signing_secret' => 'secret-for-webhook-sending-app-2',
//            'signature_header_name' => 'Signature-for-app-2',
//            'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,
//            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
//            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
//            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
//            'process_webhook_job' => '',
//        ],
    ],
];
