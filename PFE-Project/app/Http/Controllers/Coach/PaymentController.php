<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coach\StorePaymentRequest;
use App\Services\FinanceService;
use App\Services\ClientRegistryService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceiptMail;

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
        $payment = $this->financeService->logPayment($request->validated());
        
        // Load relationships for the PDF and Email
        $payment->load('client.user');
        
        // Send Receipt via Email
        try {
            Mail::to($payment->client->user->email)->send(new PaymentReceiptMail($payment));
        } catch (\Exception $e) {
            // Log error but don't block the UI
            \Illuminate\Support\Facades\Log::error("RECEIPT_EMAIL_FAILURE // TXN: " . $payment->id . " // Error: " . $e->getMessage());
        }

        return redirect()->route('coach.finance')->with('success', 'PAYMENT_CATALOGUED // Receipt_Sent');
    }

    public function downloadReceipt($id)
    {
        $payment = \App\Models\Payment::with('client.user')->findOrFail($id);
        $pdf = Pdf::loadView('pdfs.receipt', compact('payment'));
        
        return $pdf->download('receipt_' . $payment->id . '.pdf');
    }

    public function downloadReceiptSigned($id)
    {
        // This route is protected by 'signed' middleware in routes/web.php
        $payment = \App\Models\Payment::with('client.user')->findOrFail($id);
        $pdf = Pdf::loadView('pdfs.receipt', compact('payment'));
        
        return $pdf->download('receipt_' . $payment->id . '.pdf');
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
