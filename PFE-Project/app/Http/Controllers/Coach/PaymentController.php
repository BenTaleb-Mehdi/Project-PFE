<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coach\StorePaymentRequest;
use App\Services\FinanceService;
use App\Services\ClientRegistryService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $financeService;
    protected $clientService;

    public function __construct(FinanceService $financeService, ClientRegistryService $clientService)
    {
        $this->financeService = $financeService;
        $this->clientService = $clientService;
    }

    /**
     * Display the financial dashboard.
     */
    public function index(Request $request)
    {
        $metrics      = $this->financeService->getMetrics();
        $transactions = $this->financeService->getTransactions(
            $request->search,
            $request->status
        );
        $clients      = $this->clientService->getAllClients(); // For the 'Select Pupil' dropdown

        return view('coach.finance', compact('metrics', 'transactions', 'clients'));
    }

    /**
     * Log a new transaction.
     */
    public function store(StorePaymentRequest $request)
    {
        $this->financeService->logPayment($request->validated());
        return redirect()->route('coach.finance')->with('success', 'PAYMENT_CATALOGUED // Node_Active');
    }

    /**
     * Update an existing transaction.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,pending',
            'date'   => 'required|date',
        ]);

        $this->financeService->updatePayment($id, $request->all());
        return redirect()->route('coach.finance')->with('success', 'RECORD_MODIFIED // Fiscal_V3_Update');
    }

    /**
     * Destroy a financial record.
     */
    public function destroy($id)
    {
        $this->financeService->deletePayment($id);
        return redirect()->route('coach.finance')->with('success', 'TRANSACTION_WIPED // Purge_Manual');
    }
}
