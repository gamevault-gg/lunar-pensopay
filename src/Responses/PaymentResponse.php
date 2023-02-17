<?php

namespace Gamevault\Pensopay\Responses;

use Illuminate\Http\Client\Response;

class PaymentResponse
{
    protected int $id;

    protected string $orderId;

    protected string $type;

    protected int $amount;

    protected bool $captured;

    protected bool $refunded;

    protected string $currency;

    protected string $state;

    protected string $facilitator;

    protected string $reference;

    protected bool $testMode;

    protected bool $autoCapture;

    protected string $link;

    protected ?string $callbackUrl;

    protected ?string $successUrl;

    protected ?string $cancelUrl;

    protected ?string $expiresAt;

    public function __construct(protected Response $response)
    {
        /** @var object $object */
        $object = $response->object();

        $this->id = $object->id;
        $this->orderId = $object->order_id;
        $this->type = $object->type;
        $this->amount = $object->amount;
        $this->captured = $object->captured;
        $this->refunded = $object->refunded;
        $this->currency = $object->currency;
        $this->state = $object->state;
        $this->facilitator = $object->facilitator;
        $this->reference = $object->reference;
        $this->testMode = $object->testmode;
        $this->autoCapture = $object->autocapture;
        $this->link = $object->link;
        $this->callbackUrl = $object?->callback_url;
        $this->successUrl = $object?->success_url;
        $this->cancelUrl = $object?->cancel_url;
        $this->expiresAt = $object?->expires_at;
    }

    public function isSuccessful(): bool
    {
        return $this->response->successful();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCaptured(): int
    {
        return $this->captured;
    }

    public function getRefunded(): int
    {
        return $this->refunded;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getFacilitator(): string
    {
        return $this->facilitator;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    public function isAutoCapture(): bool
    {
        return $this->autoCapture;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getCallbackUrl(): ?string
    {
        return $this->callbackUrl;
    }

    public function getSuccessUrl(): ?string
    {
        return $this->successUrl;
    }

    public function getCancelUrl(): ?string
    {
        return $this->cancelUrl;
    }

    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }
}
