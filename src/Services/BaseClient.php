<?php

namespace Gamevault\Pensopay\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseClient
{
    public function __construct(public PendingRequest $pendingRequest)
    {
        $this->pendingRequest = Http::baseUrl(config('pensopay.url'))
            ->withToken(config('pensopay.token'))
            ->asJson()
            ->acceptJson()
            ->throw();
    }
}
