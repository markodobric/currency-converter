<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\NewOrderCreated;
use App\Models\Enum\CurrencyCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(OrderCreated $event): void
    {
        if ($event->order->foreignCurrency->code === CurrencyCode::GBP) {
            $recipient = 'recipient@hello.com';

            Mail::to($recipient)->send(new NewOrderCreated($event->order));
        }
    }
}
