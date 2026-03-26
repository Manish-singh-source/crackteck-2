<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display unified transactions list
     */
    public function index(Request $request): View
    {
        // Get filter inputs
        $filters = [
            'transaction_type' => $request->get('type'),
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $search = $request->get('search');
        $perPage = $request->get('per_page', 25);

        // Get transactions with filters using the service
        $transactions = $this->transactionService->getTransactions($filters, $perPage, $search);

        // Get transaction types and statuses for filter dropdowns
        $transactionTypes = TransactionService::getTransactionTypes();
        $statuses = TransactionService::getStatuses();

        // Get counts for summary cards
        $counts = $this->transactionService->getTransactionCounts();
        $amounts = $this->transactionService->getTotalAmounts();

        return view('crm.accounts.transactions', compact(
            'transactions',
            'transactionTypes',
            'statuses',
            'counts',
            'amounts',
            'filters',
            'search',
            'perPage'
        ));
    }

    /**
     * View transaction details
     */
    public function show(int $id, string $type)
    {
        $transaction = $this->transactionService->getTransactionById($id, $type);

        if (!$transaction) {
            return redirect()->route('transactions')
                ->with('error', 'Transaction not found');
        }

        return view('crm.accounts.transaction-detail', compact('transaction', 'type'));
    }

    /**
     * Export transactions to CSV
     */
    public function export(Request $request)
    {
        $filters = [
            'transaction_type' => $request->get('type'),
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $search = $request->get('search');

        // Get all transactions for export (up to 10000)
        $transactions = $this->transactionService->getTransactions($filters, 10000, $search);

        $filename = 'transactions_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($handle, [
                'ID',
                'Type',
                'Reference ID',
                'Customer Name',
                'Vendor Name',
                'Amount',
                'Status',
                'Payment Mode',
                'Date'
            ]);

            foreach ($transactions as $t) {
                fputcsv($handle, [
                    $t->id,
                    $t->transaction_type,
                    $t->reference_id,
                    $t->customer_name ?? 'N/A',
                    $t->vendor_name ?? 'N/A',
                    $t->amount,
                    $t->status,
                    $t->payment_mode ?? 'N/A',
                    $t->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
