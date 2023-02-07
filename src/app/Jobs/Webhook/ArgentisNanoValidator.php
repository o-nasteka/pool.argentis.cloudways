<?php


namespace App\Jobs\Webhook;


use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

/**
 * Class WebhookSribloValidator
 * @package App\Webhook
 */
class ArgentisNanoValidator implements SignatureValidator
{
    /**
     * @param Request $request
     * @param WebhookConfig $config
     * @return bool
     * @throws InvalidConfig
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {
            return false;
        }

        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw InvalidConfig::signingSecretNotSet();
        }

        if($signingSecret === $signature){
            return true;
        }

        return false;
    }
}
