<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\ScrapItem;
use Illuminate\Http\Request;
use App\Models\ProductSerial;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScrapItemController extends Controller
{
    //



    public function index()
    {
        $scrapItems = ScrapItem::with(['product', 'productSerial'])
            ->orderBy('created_at', 'desc')
            ->get();
            // dd($scrapItems);

        return view('/warehouse/scrap-items/index',  compact('scrapItems'));
    }

    public function addToScrap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial_ids' => 'required|string',
            'reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $serialIds = array_map('trim', explode(',', $request->serial_ids));
            $scrappedCount = 0;
            $errors = [];

            foreach ($serialIds as $serialId) {
                if (empty($serialId)) {
                    continue;
                }

                // Find the product serial
                $productSerial = ProductSerial::with('product')
                    ->where('auto_generated_serial', $serialId)
                    ->orWhere('manual_serial', $serialId)
                    // ->where('status', 'active')
                    ->first();

                if (! $productSerial) {
                    $errors[] = "Serial ID '{$serialId}' not found or already inactive";
                    continue;
                }

                $product = $productSerial;
                if (! $product) {
                    $errors[] = "Product not found for serial ID '{$serialId}'";
                    continue;
                }

                // Create scrap item record 

                ScrapItem::create([
                    'product_id' => $product->product_id,
                    'product_serial_id' => $product->id,
                    'quantity_scrapped' => 1,
                    'reason_for_scrap' => $request->reason,
                    'scrap_notes' => $request->notes ?? null,
                    'photos' => $request->photos ?? [],
                    'scrapped_by' => Auth::user()->id ?? null,
                    'scrapped_at' => now(),
                ]);

                // Update product serial status
                $productSerial->update(['status' => 'scrap']);
                
                // Decrease product quantity
                if ($product->product->stock_quantity > 0) {
                    $product->product->decrement('stock_quantity', 1);
                }

                $scrappedCount++;
            }

            DB::commit();

            if ($scrappedCount > 0) {
                $message = $scrappedCount . ' item(s) scrapped successfully';
                if (! empty($errors)) {
                    $message .= '. Some items had errors: ' . implode(', ', $errors);
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'scrapped_count' => $scrappedCount,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No items were scrapped. Errors: ' . implode(', ', $errors),
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while scrapping items: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function removeFromScrap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scrap_item_id' => 'required|exists:scrap_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            DB::beginTransaction();

            $scrapItem = ScrapItem::findOrFail($request->scrap_item_id);

            // Update product serial status
            $scrapItem->productSerial->update(['status' => 'active']);

            // Increase product quantity
            if ($scrapItem->product) {
                $scrapItem->product->increment('stock_quantity', 1);
            }

            // Delete the scrap item record
            $scrapItem->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from scrap successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the item from scrap: ' . $e->getMessage(),
            ], 500);
        }
    }
}
