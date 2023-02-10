<?php

namespace Gamevault\Pensopay;

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
        $this->paymentService->getPayments();
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
