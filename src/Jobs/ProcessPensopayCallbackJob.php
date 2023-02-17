<?php

namespace Gamevault\Pensopay\Jobs;

use Lunar\Models\Transaction;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessPensopayCallbackJob extends ProcessWebhookJob
{
    public function handle()
    {
        $payload = $this->webhookCall->payload;

        /** @var Transaction $transaction */
        $transaction = Transaction::query()->where('reference', $payload['id'])->latest()->first();

        $this->storeTransaction($transaction, $payload);
    }

    private function storeTransaction(Transaction $previousTransaction, array $payload)
    {
        $paymentType = match ($payload['state']) {
            'pending', 'authorized' => 'intent',
            'captured' => 'capture ',
        };

        $previousTransaction->order->transactions()->create([
            'parent_transaction_id' => $previousTransaction->id,
            'success' => true,
            'type' => $paymentType,
            'driver' => 'pensopay',
            'amount' => $payload['amount'],
            'reference' => $payload['id'],
            'status' => $payload['state'],
            'notes' => '',
            'card_type' => $payload['payment_details']['brand'],
            'last_four' => $payload['payment_details']['card_last4'],
            'captured_at' => $payload['state'] == 'captured' ? now() : null,
            'meta' => [
                'captured' => $payload['captured'],
                'refunded' => $payload['refunded'],
                'autocapture' => $payload['autocapture'],
                'testmode' => $payload['testmode'],
                'facilitator' => $payload['testmode'],
                'card_bin' => $payload['payment_details']['card_bin'],
                'exp_year' => $payload['payment_details']['exp_year'],
                'exp_month' => $payload['payment_details']['exp_month'],
                '3d_secure' => $payload['payment_details']['3d_secure'],
                'card_country' => $payload['payment_details']['card_country'],
                'is_corporate' => $payload['payment_details']['is_corporate'],
                'customer_country' => $payload['payment_details']['customer_country'],
            ],
        ]);
    }
}
