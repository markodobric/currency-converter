<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Action\CreateOrder;
use App\Data\DecimalValue;
use App\Models\Currency;
use Illuminate\Console\Command;

class CreateOrderCommand extends Command
{
    protected $signature = 'app:create-order-command';

    protected $description = 'Command description';

    public function handle(CreateOrder $action): void
    {
        call_user_func($action, new DecimalValue('500'), Currency::find(1), Currency::find(3));
    }
}
