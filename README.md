# A community Lunar payment driver for Pensopay

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gamevault/lunar-pensopay.svg?style=flat-square)](https://packagist.org/packages/gamevault/lunar-pensopay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/gamevault/lunar-pensopay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/gamevault/lunar-pensopay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/gamevault/lunar-pensopay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/gamevault/lunar-pensopay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gamevault/lunar-pensopay.svg?style=flat-square)](https://packagist.org/packages/gamevault/lunar-pensopay)

Easily integrate Pensopay into Lunar with the community payment driver for Pensopay. This integration are based on [PensoPay API docs](https://docs.pensopay.com/reference/getting-started-with-your-api)

## ToDo
There is still some minor stuff to take into consideration
- [ ] Defining success_url, cancel_url and callback_url urls with id params in the urls.
- [ ] Dynamic selection of facilitator (payment types: creditcard, viabill, expressbank, paypal and anyday).
- [ ] Tests.

## Installation

You can install the package via composer:

```bash
composer require gamevault/lunar-pensopay
```
This package uses the spatie [laravel-webhook-client](https://github.com/spatie/laravel-webhook-client) package to handle the callbacks sent from Pensopay.

You can publish the configs and run the migrations with:

```bash
php artisan vendor:publish --tag="lunar-pensopay-config"
php artisan vendor:publish --provider="Spatie\WebhookClient\WebhookClientServiceProvider" --tag="webhook-client-config"
php artisan migrate
```

This is the contents of the published pensopay config file:

```php
return [
    'policy' => env('AUTO_CAPTURE', false),
    'url' => env('PENSOPAY_URL', 'https://api.pensopay.com/v1'),
    'token' => env('PENSOPAY_TOKEN'),
    'testmode' => env('PENSOPAY_TESTMODE', false),
];
```
The webhook-client.php should look like the following:
```php
<?php

return [
    'configs' => [
        [
            'name' => 'pensopay-webhook',
            'signing_secret' => config('PENSOPAY_SIGNING_SECRET'),
            'signature_header_name' => 'pensopay-signature',
            'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => \Gamevault\Pensopay\Jobs\ProcessPensopayCallbackJob::class,
        ],
    ],

    /*
     * The integer amount of days after which models should be deleted.
     *
     * 7 deletes all records after 1 week. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,
];
```

The webhook endpoint can be defined anywhere in the route files with the following:
```php
Route::webhooks('pensopay-webhook', 'pensopay-webhook');
```

## Usage
To get started, the payment driver must be registered at the AppServiceProvider:
```php
public function register()
{
    Payments::extend('pensopay', function ($app) {
       return $app->make(\Gamevault\Pensopay\PensopayPaymentType::class);
    });
}
```

The payment methods can be invoked like the following:
```php
/** @var Pensopay $paymentDriver */
$paymentDriver = Payments::driver('pensopay');
$paymentDriver->cart($cart);
$paymentAuthorize = $paymentDriver->authorize();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Kristoffer Aagard Mikkelsen](https://github.com/kris914g)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
