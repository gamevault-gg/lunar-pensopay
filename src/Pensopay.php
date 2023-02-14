<?php

namespace Gamevault\Pensopay;

use Gamevault\Pensopay\Enums\FacilitatorEnum;
use Gamevault\Pensopay\Enums\PaymentStateEnum;
use Gamevault\Pensopay\Responses\PaymentResponse;
use Gamevault\Pensopay\Services\PaymentService;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;

class Pensopay extends AbstractPayment
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function authorize(): PaymentAuthorize
    {
        if (! $this->order) {
            if (! $this->order = $this->cart->order) {
                $this->order = $this->cart->createOrder();
            }
        }

        if ($this->order->placed_at) {
            return new PaymentAuthorize(
                success: false,
                message: 'This order has already been placed',
            );
        }

        //ToDo handle facilitator better
        $paymentResponse = $this->paymentService->createPayment(
            $this->order,
            FacilitatorEnum::Creditcard
        );

        if (in_array($paymentResponse->getState(), [
            PaymentStateEnum::Rejected,
            PaymentStateEnum::Canceled,
        ])) {
            return new PaymentAuthorize(
                success: false,
                message: 'Something is broken',
            );
        }

        $this->storeTransaction($paymentResponse);

        if ($paymentResponse->isSuccessful()) {
            $this->order->update([
                'placed_at' => now(),
            ]);
        }

        if ($this->cart) {
            if (! $this->cart->meta) {
                $this->cart->update([
                    'meta' => [
                        'payment_intent' => $paymentResponse->getId(),
                    ],
                ]);
            } else {
                $this->cart->meta->payment_intent = $paymentResponse->getId();
                $this->cart->save();
            }
        }

        return new PaymentAuthorize(true, $paymentResponse->getLink());
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        return new PaymentRefund(true);
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        return new PaymentCapture(true);
    }

    private function storeTransaction(PaymentResponse $paymentResponse)
    {
        $data = [
            'success' => $paymentResponse->isSuccessful(),
            'type' => $paymentResponse->transactionType(),
            'driver' => 'pensopay',
            'amount' => $paymentResponse->getAmount(),
            'reference' => $paymentResponse->getId(),
            'status' => $paymentResponse->getState(),
            'notes' => null,
            'card_type' => null,
            'last_four' => null,
            'captured_at' => $paymentResponse->isSuccessful() ? ($paymentResponse->transactionType() == 'capture' ? now() : null) : null,
            'meta' => [
                'urls' => [
                    'link' => $paymentResponse->getLink(),
                    'callback_url' => $paymentResponse->getCallbackUrl(),
                    'success_url' => $paymentResponse->getSuccessUrl(),
                    'cancel_url' => $paymentResponse->getCancelUrl(),
                ],
                'captured' => $paymentResponse->getCaptured(),
                'refunded' => $paymentResponse->getRefunded(),
                'expires_at' => $paymentResponse->getExpiresAt(),
                'pensopay_reference' => $paymentResponse->getReference(),
                'autocapture' => $paymentResponse->isAutoCapture(),
                'testmode' => $paymentResponse->isTestMode(),
                'facilitator' => $paymentResponse->getFacilitator(),
            ],
        ];
        $this->order->transactions()->create($data);
    }
}
