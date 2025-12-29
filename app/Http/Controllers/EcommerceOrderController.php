<?php

namespace App\Http\Controllers;

use App\Models\EcommerceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class EcommerceOrderController extends Controller
{
    /**
     * Display a listing of ecommerce orders.
     */
    public function index(Request $request)
    {
        $query = EcommerceOrder::with(['user', 'orderItems']);

        // Search functionality
        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('total_amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && ! empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->has('date_from') && ! empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && ! empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get status counts for filter tabs
        $statusCounts = [
            'all' => EcommerceOrder::count(),
            'pending' => EcommerceOrder::where('status', 'pending')->count(),
            'processing' => EcommerceOrder::where('status', 'processing')->count(),
            'shipped' => EcommerceOrder::where('status', 'shipped')->count(),
            'delivered' => EcommerceOrder::where('status', 'delivered')->count(),
            'cancelled' => EcommerceOrder::where('status', 'cancelled')->count(),
        ];
        dd($orders);

        return view('e-commerce.ecommerce-orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display the specified ecommerce order.
     */
    public function show($id)
    {
        $order = EcommerceOrder::with(['user', 'orderItems.ecommerceProduct.warehouseProduct'])
            ->findOrFail($id);

        // Calculate totals
        $totals = $this->calculateOrderTotals($order);

        return view('e-commerce.ecommerce-orders.show', compact('order', 'totals'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        try {
            $order = EcommerceOrder::findOrFail($id);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            Log::info('Order status updated', [
                'order_id' => $id,
                'order_number' => $order->order_number,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'updated_by' => auth()->user()->name ?? 'System',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update order status', [
                'order_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
            ], 500);
        }
    }

    /**
     * Generate PDF invoice for the order.
     */
    public function generateInvoice($id)
    {
        $order = EcommerceOrder::with(['user', 'orderItems.ecommerceProduct.warehouseProduct'])
            ->findOrFail($id);

        $totals = $this->calculateOrderTotals($order);

        $pdf = PDF::loadView('e-commerce.ecommerce-orders.invoice', compact('order', 'totals'));

        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    /**
     * Bulk delete orders.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:ecommerce_orders,id',
        ]);

        try {
            DB::beginTransaction();

            $deletedCount = EcommerceOrder::whereIn('id', $request->order_ids)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} orders deleted successfully",
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Bulk delete failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete orders',
            ], 500);
        }
    }

    /**
     * Calculate order totals including tax information.
     */
    private function calculateOrderTotals($order)
    {
        $subtotal = $order->orderItems->sum('taxable_value');
        $totalTax = $order->orderItems->sum('igst_amount');
        $totalAmount = $order->orderItems->sum('final_amount');
        $shippingCharges = $order->shipping_charges;
        $grandTotal = $totalAmount + $shippingCharges;

        // Calculate rounding off
        $roundedTotal = round($grandTotal);
        $roundingOff = $roundedTotal - $grandTotal;

        return [
            'subtotal' => $subtotal,
            'total_tax' => $totalTax,
            'total_amount' => $totalAmount,
            'shipping_charges' => $shippingCharges,
            'grand_total' => $grandTotal,
            'rounded_total' => $roundedTotal,
            'rounding_off' => $roundingOff,
            'total_in_words' => $this->convertNumberToWords($roundedTotal),
        ];
    }

    /**
     * Convert number to words (Indian format).
     */
    private function convertNumberToWords($number)
    {
        $number = (int) $number;

        if ($number == 0) {
            return 'Zero Rupees Only';
        }

        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
            30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety',
        ];

        $result = '';

        if ($number >= 10000000) { // Crores
            $crores = (int) ($number / 10000000);
            $result .= $this->convertNumberToWords($crores).' Crore ';
            $number %= 10000000;
        }

        if ($number >= 100000) { // Lakhs
            $lakhs = (int) ($number / 100000);
            $result .= $this->convertNumberToWords($lakhs).' Lakh ';
            $number %= 100000;
        }

        if ($number >= 1000) { // Thousands
            $thousands = (int) ($number / 1000);
            $result .= $this->convertNumberToWords($thousands).' Thousand ';
            $number %= 1000;
        }

        if ($number >= 100) { // Hundreds
            $hundreds = (int) ($number / 100);
            $result .= $words[$hundreds].' Hundred ';
            $number %= 100;
        }

        if ($number >= 20) {
            $tens = (int) ($number / 10) * 10;
            $result .= $words[$tens].' ';
            $number %= 10;
        }

        if ($number > 0) {
            $result .= $words[$number].' ';
        }

        return trim($result).' Rupees Only';
    }
}
