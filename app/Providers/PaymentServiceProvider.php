<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Payments\{PaymentRetrieverInterface, MpPaymentRetriever};

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentRetrieverInterface::class, MpPaymentRetriever::class);
    }
}
