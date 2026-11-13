<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Quotation;
use App\Models\QuotationInvoice;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);
        $from = isset($validated['from']) ? Carbon::parse($validated['from'])->startOfDay() : now()->startOfMonth();
        $to = isset($validated['to']) ? Carbon::parse($validated['to'])->endOfDay() : now()->endOfDay();

        $leads = Lead::whereBetween('created_at', [$from, $to]);
        $quotes = Quotation::whereBetween('quote_date', [$from->toDateString(), $to->toDateString()]);
        $invoices = QuotationInvoice::whereBetween('invoice_date', [$from->toDateString(), $to->toDateString()]);
        $leadCount = (clone $leads)->count();
        $quoteCount = (clone $quotes)->count();
        $wonCount = (clone $leads)->where('status', 'won')->count();
        $acceptedQuoteCount = (clone $quotes)->whereIn('status', ['accepted', 'converted'])->count();

        $metrics = [
            'leads' => $leadCount,
            'qualified' => (clone $leads)->whereIn('status', ['qualified', 'proposal', 'won'])->count(),
            'won' => $wonCount,
            'quotes' => $quoteCount,
            'accepted_quotes' => $acceptedQuoteCount,
            'revenue_received' => (clone $invoices)->sum('paid_amount'),
            'invoice_value' => (clone $invoices)->sum('grand_total'),
            'lead_conversion' => $leadCount ? round(($wonCount / $leadCount) * 100, 1) : 0,
            'quote_conversion' => $quoteCount ? round(($acceptedQuoteCount / $quoteCount) * 100, 1) : 0,
        ];

        $pipeline = (clone $leads)->selectRaw('status, COUNT(*) as total, COALESCE(SUM(estimated_value), 0) as value')->groupBy('status')->get();
        $salesPerformance = Staff::where('staff_role', 'sales_person')->orderBy('first_name')->get()->map(function ($staff) use ($from, $to) {
            $staffLeads = Lead::where('staff_id', $staff->id)->whereBetween('created_at', [$from, $to]);
            return ['name' => trim($staff->first_name.' '.$staff->last_name), 'leads' => (clone $staffLeads)->count(), 'won' => (clone $staffLeads)->where('status', 'won')->count(), 'quoted_value' => Quotation::where('staff_id', $staff->id)->whereBetween('quote_date', [$from->toDateString(), $to->toDateString()])->sum('total_amount')];
        });
        $recentLeads = (clone $leads)->with(['customer', 'staff'])->latest()->limit(10)->get();

        return view('crm.sales-reports.index', compact('from', 'to', 'metrics', 'pipeline', 'salesPerformance', 'recentLeads'));
    }
}
