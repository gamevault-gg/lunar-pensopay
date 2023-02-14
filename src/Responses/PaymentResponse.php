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

    protected string $callbackUrl;

    protected string $successUrl;

    protected string $cancelUrl;

    protected string $expiresAt;

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
        $this->callbackUrl = $object->callback_url;
        $this->successUrl = $object->success_url;
        $this->cancelUrl = $object->cancel_url;
        $this->expiresAt = $object->expires_at;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->response->successful();
    }

    /**
     * @return string
     */
    public function transactionType(): string
    {
        return $this->isAutoCapture() ? 'capture' : 'intent';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getCaptured(): int
    {
        return $this->captured;
    }

    /**
     * @return int
     */
    public function getRefunded(): int
    {
        return $this->refunded;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getFacilitator(): string
    {
        return $this->facilitator;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @return bool
     */
    public function isAutoCapture(): bool
    {
        return $this->autoCapture;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    /**
     * @return string
     */
    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }

    /**
     * @return string
     */
    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    /**
     * @return string
     */
    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }
}
