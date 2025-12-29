<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStockRequestRequest;
use App\Models\DeliveryMan;
use App\Models\SparePartRequest;
use App\Models\StockRequest;
use App\Models\StockRequestItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SparePartController extends Controller
{
    /**
     * Display a listing of all spare part requests.
     */
    public function index()
    {
        // stock requests ke table ka data display hoga with product details from stock_request_items table
        $stockRequests = StockRequest::with(['requestedBy', 'stockRequestItems.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($stockRequests);
        return view('/warehouse/spare-parts-requests/index', compact('stockRequests'));
    }

    /**
     * Display a specific spare part request.
     */
    public function view($id)
    {
        $sparePartRequest = SparePartRequest::with([
            'product',
            'engineer',
            'deliveryMan',
            'customerServiceRequest',
        ])->findOrFail($id);

        $deliveryMen = DeliveryMan::where('status', 'Active')->get();
        dd($sparePartRequest);

        return view('/warehouse/spare-parts-requests/view', compact('sparePartRequest', 'deliveryMen'));
    }

    /**
     * Assign a delivery man to a spare part request.
     */
    public function assignDeliveryMan(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'delivery_man_id' => 'required|exists:delivery_men,id',
            'approval_status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $sparePartRequest = SparePartRequest::findOrFail($id);
        $sparePartRequest->update([
            'quantity' => $request->quantity,
            'delivery_man_id' => $request->delivery_man_id,
            'approval_status' => $request->approval_status,
        ]);

        return redirect()->route('spare-parts.index', $id)
            ->with('success', 'Delivery man assigned successfully.');
    }

    /**
     * Display the specified stock request for viewing/editing.
     */
    public function warehouse_show(StockRequest $stockRequest): View
    {
        $stockRequest->load(['requestedBy', 'stockRequestItems.product']);
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('/warehouse/spare-parts-requests/edit', compact('stockRequest', 'users'));
    }

    /**
     * Update the specified stock request.
     */
    public function warehouse_update(UpdateStockRequestRequest $request, StockRequest $stockRequest): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Update status fields if provided
            $updateData = [];
            if ($request->filled('approval_status')) {
                $updateData['approval_status'] = $request->approval_status;
            }
            if ($request->filled('final_status')) {
                $updateData['final_status'] = $request->final_status;
            }

            if (! empty($updateData)) {
                $stockRequest->update($updateData);
            }

            // Handle product updates if provided
            if ($request->filled('products')) {
                $this->updateStockRequestItems($stockRequest, $request->products);
            }

            // Handle new products if provided
            if ($request->filled('new_products')) {
                foreach ($request->new_products as $productData) {
                    StockRequestItem::create([
                        'stock_request_id' => $stockRequest->id,
                        'product_id' => $productData['product_id'],
                        'quantity' => $productData['quantity'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('spare-parts.index')
                ->with('success', 'Stock request updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating stock request: '.$e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to update stock request. Please try again.');
        }
    }

    /**
     * Update stock request items.
     */
    private function updateStockRequestItems(StockRequest $stockRequest, array $products): void
    {
        foreach ($products as $productData) {
            if (isset($productData['action']) && $productData['action'] === 'delete') {
                // Delete the item
                if (isset($productData['id'])) {
                    StockRequestItem::where('id', $productData['id'])
                        ->where('stock_request_id', $stockRequest->id)
                        ->delete();
                }
            } elseif (isset($productData['id'])) {
                // Update existing item
                StockRequestItem::where('id', $productData['id'])
                    ->where('stock_request_id', $stockRequest->id)
                    ->update([
                        'product_id' => $productData['product_id'],
                        'quantity' => $productData['quantity'],
                    ]);
            } else {
                // Add new item (if no ID provided)
                StockRequestItem::create([
                    'stock_request_id' => $stockRequest->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                ]);
            }
        }
    }

    public function removeProduct($id)
    {
        try {
            DB::beginTransaction();

            $item = StockRequestItem::findOrFail($id);
            $item->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from stock request.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product.',
                'error' => $e->getMessage(),
                'error_code' => 500,
            ]);
        }

    }
}
