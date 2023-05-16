<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Action\CreateOrder;
use App\Data\PurchaseData;
use App\Models\Enum\CurrencyCode;
use App\Repository\CurrencyRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private CurrencyRepositoryInterface $currencyRepository)
    {}

    public function index(): View
    {
        return view('home', [
            'currencies' => $this->currencyRepository->findForeignCurrencies(),
            'usd' => $this->currencyRepository->findByCode(CurrencyCode::USD),
        ]);
    }

    public function buy(PurchaseData $data, CreateOrder $action): RedirectResponse
    {
        call_user_func($action, $data);

        return redirect()->back()->with('message', 'Success!');
    }
}
