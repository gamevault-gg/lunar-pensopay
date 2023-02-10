<?php

namespace Gamevault\Pensopay;

use Gamevault\Pensopay\Enums\FacilitatorEnum;
use Gamevault\Pensopay\Enums\PaymentEnum;
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
            // Somethings gone wrong!
            return new PaymentAuthorize(
                success: false,
                message: 'This order has already been placed',
            );
        }

        //ToDo handle facilitator better

        $paymentResponse = json_decode($this->paymentService->createPayment(
            $this->order,
            FacilitatorEnum::Creditcard,
            false,
            true
        )->body());

        //ToDo Handle if autoCapture is enabled
        if ($paymentResponse->state == PaymentEnum::Authorized) {
        }

        if ($this->cart) {
            if (! $this->cart->meta) {
                $this->cart->update([
                    'meta' => [
                        'payment_intent' => $paymentResponse->id,
                    ],
                ]);
            } else {
                $this->cart->meta->payment_intent = $paymentResponse->id;
                $this->cart->save();
            }
        }

        //Ensure that it is primarly Pending or Authorized states
        if (! in_array($paymentResponse->state, [
            PaymentEnum::Rejected,
            PaymentEnum::Canceled,
            PaymentEnum::Captured,
            PaymentEnum::Refunded,
        ])) {
            return new PaymentAuthorize(
                success: false,
                message: 'Something is broken',
            );
        }
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        // TODO: Implement refund() method.
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        // TODO: Implement capture() method.
    }
}
