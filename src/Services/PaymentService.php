<?php

namespace Gamevault\Pensopay\Services;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Http\Client\Response;
use Lunar\Models\Currency;

class PaymentService extends BaseClient
{
    /**
     * Returns a paginated list of payments
     *
     * @param int $perPage
     * @param int $page
     * @param string|null $orderId
     * @param Currency|null $currency
     * @param DateTimeInterface|string|null $fromDate
     * @param DateTimeInterface|string|null $toDate
     *
     * @return Response
     */
    public function getPayments(
        int $perPage = 15,
        int $page = 1,
        string $orderId = null,
        Currency $currency = null,
        DateTimeInterface|string $fromDate = null,
        DateTimeInterface|string $toDate = null
    ): Response {
        $queryParams = [
            'per_page' => $perPage,
            'page'     => $page,
        ];

        if ($orderId != null) {
           $queryParams = array_merge($queryParams, [
                'order_id' => $orderId,
           ]);
        }

        if ($currency != null) {
            $queryParams = array_merge($queryParams, [
                'currency' => $currency->getAttributes()['code'],
            ]);
        }

        if ($fromDate != null) {
            $formattedDate = Carbon::parse($fromDate)->toIso8601String();

            $queryParams = array_merge($queryParams, [
                'date_from' => $formattedDate,
            ]);
        }

        if ($toDate != null) {
            $formattedDate = Carbon::parse($toDate)->toIso8601String();

            $queryParams = array_merge($queryParams, [
                'date_to' => $formattedDate,
            ]);
        }

        //Todo make class to store response.
        $response = $this->pendingRequest->get($this->url(), $queryParams);

        return $response;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return '/payments';
    }
}
