<?php

namespace Gamevault\Pensopay\Jobs;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessPensopayCallbackJob extends ProcessWebhookJob
{
    public function handle()
    {
        $test = $this->webhookCall->payload;
    }
}
