<?php

namespace App\Http\Controllers;

use App\Services\PaymentLogService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request, PaymentLogService $paymentLog)
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(['all', 'pending', 'completed', 'failed', 'refunded'])],
            'source' => ['nullable', Rule::in(['order', 'amc', 'service'])],
            'search' => ['nullable', 'string', 'max:255'],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d', Rule::when($request->filled('from'), 'after_or_equal:from')],
        ]);
        $status = $filters['status'] ?? 'all';
        $query = $paymentLog->query();

        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }
        if ($search = trim($filters['search'] ?? '')) {
            foreach (preg_split('/\s+/', $search) as $term) {
                $query->where(function ($query) use ($term) {
                    foreach (['reference', 'transaction_id', 'first_name', 'last_name', 'description', 'invoice_number'] as $column) {
                        $query->orWhere($column, 'like', '%'.$term.'%');
                    }
                });
            }
        }
        if (! empty($filters['from'])) {
            $query->whereDate('payment_date', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('payment_date', '<=', $filters['to']);
        }

        $counts = (clone $query)->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $counts->put('all', $counts->sum());
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        $payments = $query->orderByDesc('payment_date')->orderBy('source')->orderByDesc('id')
            ->paginate(25)->withQueryString();

        return view('crm.accounts.payments', compact('payments', 'counts', 'status', 'filters'));
    }
}
