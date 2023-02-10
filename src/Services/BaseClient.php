<?php

namespace Gamevault\Pensopay\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseClient
{
    public function __construct(public PendingRequest $pendingRequest)
    {
        $settings = config('services.pensopay');
        $this->pendingRequest = Http::baseUrl($settings['url'])
            ->withToken($settings['token'])
            ->asJson()
            ->acceptJson()
            ->throw();
    }

}
