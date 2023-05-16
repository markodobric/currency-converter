<h1>New Order Created.</h1>

<div>
    <div>
        Foreign currency purchased: {{ $order->baseCurrency->code->value }}
    </div>
    <div>
        Amount paid in USD: {{ $order->base_currency_amount }}
    </div>
    <div>
        Amount of foreign currency purchased: {{ $order->foreign_currency_amount }}
    </div>
    <div>
        Exchange rate for foreign currency: {{ $order->foreign_currency_exchange_rate }}
    </div>
    <div>
        Surcharge percentage: {{ $order->surcharge_percentage }}
    </div>
    <div>
        Amount of surcharge: {{ $order->surcharge_amount }}
    </div>
    <div>
        Amount of surcharge: {{ $order->surcharge_amount }}
    </div>
    <div>
        Discount percentage: {{ $order->discount_percentage }}
    </div>
    <div>
        Discount amount: {{ $order->discount_amount }}
    </div>
    <div>
        Total: {{ $order->total }}
    </div>
    <div>
        Date created: {{ $order->created_at->format('Y-m-d') }}
    </div>
</div>
