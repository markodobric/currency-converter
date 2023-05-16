# Setting it up

These are the steps to get the app up and running.

1. Clone the repository,
2. `composer install`,
3. Copy `.env.example` to `.env` and run `php artisan key:generate`,
4. Create a MySQL database. Add the database name to your `.env`,
5. Run migrations: `php artisan migrate`,
6. Seed database: `php artisan db:seed`,
7. Run server `php artisan serve`.
8. Install npm dependencies `npm install`,
9. Run npm scripts `npm run dev`.


# Import currency exchange rates

To import exhange rates, we use APILayer 3rd party service (https://apilayer.com/marketplace/exchangerates_data-api).

Subscribe to free plan, grab your API Key and put it to `APILAYER_API_KEY` environment variable.

Run `php artisan app:import-currency-exchange-rate`.
