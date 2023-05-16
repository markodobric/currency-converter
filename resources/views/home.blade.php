<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <form method="POST" action="{{ route('buy') }}">
                @csrf
                <input id="currency_from" type="hidden" name="from" value="{{ $usd->id }}">
                <div class="flex flex-col">
                    <label class="mb-2 text-sm" for="amount">Amount in USD</label>
                    <input id="amount" name="amount" class="border px-4 py-2 border-blue-500 rounded-md hover:border-blue-600 focus-visible:outline-blue-200 mb-4" type="text" placeholder="100.00">
                    @error('amount')
                        <span class="text-red-500 mb-2 text-small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="mb-2 text-sm" for="currency">Currency</label>
                    <select name="to" id="currency" class="border border-blue-500 hover:border-blue-600">
                        @foreach ($currencies as $i => $currency)
                            <option value="{{ $currency->id }}" @if($i === 0) selected @endif>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                    @error('to')
                        <span class="text-red-500 mb-2 text-small">{{ $message }}</span>
                    @enderror
                </div>
                <p class="mb-4">Precalculate: <strong id="calculated_value"></strong></p>
                <button id="buy" class="border px-4 py-2 bg-blue-400 hover:bg-blue-500 w-full text-white rounded-md" type="submit">Buy</button>
            </form>

            @if(session()->has('message'))
                <h1 class="text-green-500 mt-4 text-xl">{{ session()->get('message') }}</h1>
            @endif
        </div>

        <script>
            const amount = document.getElementById('amount');
            const currency_from = document.getElementById('currency_from');
            const currency_to = document.getElementById('currency');
            const calculated_value = document.getElementById('calculated_value');

            amount.addEventListener("input", (e) => {
                axios.post(
                    '/currency-converter/calculate',
                    {
                        "from": currency_from.value,
                        "to": currency_to.value,
                        "amount": e.target.value,
                    }
                ).then(response => {
                    calculated_value.textContent = response.data.value;
                }).catch(e)
                {
                    console.log(e)
                }
            })

            currency_to.addEventListener("change", (e) => {
                axios.post(
                    '/currency-converter/calculate',
                    {
                        "from": currency_from.value,
                        "to": e.target.value,
                        "amount": amount.value,
                    }
                ).then(response => {
                    calculated_value.textContent = response.data.value;
                }).catch(e)
                {
                    console.log(e)
                }
            })
        </script>
    </body>
</html>
