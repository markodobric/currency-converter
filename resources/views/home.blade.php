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
    </head>
    <body class="antialiased">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <form method="POST" action="{{ route('buy') }}">
                @csrf
                <input type="hidden" name="from" value="{{ $usd->id }}">
                <div class="flex flex-col">
                    <label class="mb-2 text-sm" for="amount">Amount in USD</label>
                    <input id="amount" name="amount" class="border px-4 py-2 border-blue-500 rounded-md hover:border-blue-600 focus-visible:outline-blue-200 mb-4" type="text" placeholder="100.00">
                    @error('amount')
                        <span class="text-red-500 mb-2 text-small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="mb-2 text-sm" for="amount">Currency</label>
                    <select name="to" id="currency" class="border border-blue-500 hover:border-blue-600">
                        @foreach ($currencies as $i => $currency)
                            <option value="{{ $currency->id }}" @if($i === 0) selected @endif>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                    @error('to')
                        <span class="text-red-500 mb-2 text-small">{{ $message }}</span>
                    @enderror
                </div>
                <p class="mb-4">Precalculate: <strong>124.00</strong></p>
                <button id="buy" class="border px-4 py-2 bg-blue-400 hover:bg-blue-500 w-full text-white rounded-md" type="submit">Buy</button>
            </form>

            @if(session()->has('message'))
                <h1 class="text-green-500 mt-4 text-xl">{{ session()->get('message') }}</h1>
            @endif
        </div>
    </body>
</html>
