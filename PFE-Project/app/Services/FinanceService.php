<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Log;

class FinanceService
{
    /**
     * Log a new payment into the system.
     */
    public function logPayment(array $data): Payment
    {
        $payment = Payment::create([
            'client_id' => $data['client_id'],
            'amount'    => $data['amount'],
            'date'      => $data['date'] ?? now()->toDateString(),
            'status'    => $data['status'] ?? 'pending',
        ]);

        // Load relationships for the PDF and Email
        $payment->load('client.user');

        // Send Receipt via Email
        try {
            if ($payment->client && $payment->client->user && $payment->client->user->email) {
                Mail::to($payment->client->user->email)->send(new PaymentReceiptMail($payment));
            }
        } catch (\Exception $e) {
            // Log error but don't block the UI
            Log::error("RECEIPT_EMAIL_FAILURE // TXN: " . $payment->id . " // Error: " . $e->getMessage());
        }

        return $payment;
    }

    /**
     * Get a specific payment record with client and user details.
     */
    public function getPaymentWithClient(int $id): Payment
    {
        return Payment::with('client.user')->findOrFail($id);
    }

    /**
     * Update an existing transaction record.
     */
    public function updatePayment(int $id, array $data): bool
    {
        $payment = Payment::findOrFail($id);
        return $payment->update($data);
    }

    /**
     * Remove a transaction record.
     */
    public function deletePayment(int $id): bool
    {
        return Payment::destroy($id);
    }

    /**
     * Get aggregated financial metrics for the dashboard.
     */
    public function getMetrics(): array
    {
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $currentRevenue = Payment::where('status', 'paid')
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('amount');

        $lastMonthRevenue = Payment::where('status', 'paid')
            ->whereMonth('date', $lastMonth->month)
            ->whereYear('date', $lastMonth->year)
            ->sum('amount');

        $growth = 0;
        if ($lastMonthRevenue > 0) {
            $growth = (($currentRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }

        $pendingCount = Payment::where('status', 'pending')->count();

        return [
            'total_revenue_mtd' => number_format($currentRevenue, 0),
            'pending_syncs'     => str_pad($pendingCount, 2, '0', STR_PAD_LEFT),
            'growth_mtd'        => ($growth >= 0 ? '+' : '') . number_format($growth, 1) . '%',
        ];
    }

    /**
     * Get paginated transaction history with optional filters.
     */
    public function getTransactions(?string $search = null, ?string $status = null)
    {
        $query = Payment::with('client.user');

        if ($search) {
            $query->whereHas('client.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        if ($status && $status !== 'ALL_TRANSACTIONS') {
            $statusValue = str_replace('_', '', strtolower($status));
            $query->where('status', $statusValue);
        }

        return $query->latest('date')->paginate(15);
    }
}
