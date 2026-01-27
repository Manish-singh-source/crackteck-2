<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\View\View;
use App\Models\DeliveryMan;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use App\Models\SparePartRequest;
use App\Models\StockRequestItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateStockRequestRequest;
use App\Models\ServiceRequestProductRequestPart;

class SparePartController extends Controller
{
    /**
     * Display a listing of all spare part requests.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $stockRequests = ServiceRequestProductRequestPart::query();

        if ($status !== 'all') {
            $stockRequests->where('status', $status);
        }

        $stockRequests = $stockRequests
            ->withCount('requestedPart')
            ->with([
                'serviceRequest',
                'serviceRequestProduct',
                'fromEngineer',
                'assignedEngineer',
                'requestedPart',
            ])
            ->orderByDesc('created_at')
            ->get();

        if ($request->is('demo/crm/spare-parts-requests')) {
            return view('crm.spare-parts-requests.index', compact('stockRequests'));
        }

        if ($request->is('demo/warehouse/spare-parts')) {
            return view('warehouse.spare-parts-requests.index', compact('stockRequests'));
        }

        abort(404);
    }

    /**
     * Display a specific spare part request.
     */
    // public function view($id)
    // {
    //     $stockRequests = ServiceRequestProductRequestPart::with([
    //         'serviceRequest.customer',
    //         'serviceRequest.customer.primaryAddress',
    //         'serviceRequestProduct',
    //         'fromEngineer',
    //         'assignedEngineer',
    //         'requestedPart.product',
    //         'requestedPart.product.parentCategorie',
    //         'requestedPart.product.brand',
    //         'requestedPart.product.subCategorie',
    //     ])
    //         ->findOrFail($id);
    //     // dd($stockRequests);
    //     $deliveryMen = Staff::where('staff_role', 'delivery_man')->get();
    //     $engineers = Staff::where('staff_role', 'engineer')->get();
    //     return view('crm.spare-parts-requests.view', compact('stockRequests', 'deliveryMen', 'engineers'));
    // }

    public function view(Request $request, $id)
    {
        $stockRequests = ServiceRequestProductRequestPart::with([
            'serviceRequest.customer',
            'serviceRequest.customer.primaryAddress',
            'serviceRequestProduct',
            'fromEngineer',
            'assignedEngineer',
            'requestedPart.product',
            'requestedPart.product.parentCategorie',
            'requestedPart.product.brand',
            'requestedPart.product.subCategorie',
        ])->findOrFail($id);

        $deliveryMen = Staff::where('staff_role', 'delivery_man')->get();
        $engineers   = Staff::where('staff_role', 'engineer')->get();

        if ($request->routeIs('spare-parts-requests.view')) {
            return view('crm.spare-parts-requests.view', compact('stockRequests', 'deliveryMen', 'engineers'));
        }

        if ($request->routeIs('spare-parts.view')) {
            return view('warehouse.spare-parts-requests.view', compact('stockRequests', 'deliveryMen', 'engineers'));
        }
    }


    public function assignPerson(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'assigned_person_type' => 'required|in:engineer,delivery_man',
            'delivery_man_id' => 'nullable|exists:staff,id',
            'engineer_id' => 'nullable|exists:staff,id',
        ]);

        // dd($request->all());
        if ($request->assigned_person_type == 'engineer') {
            $data = [
                'quantity' => $request->quantity,
                'assigned_person_type' => $request->assigned_person_type,
                'assigned_person_id' => $request->engineer_id,
                'status' => 'approved',
            ];
        } else {
            $data = [
                'quantity' => $request->quantity,
                'assigned_person_type' => $request->assigned_person_type,
                'assigned_person_id' => $request->delivery_man_id,
                'status' => 'approved',
            ];
        }

        $sparePartRequest = ServiceRequestProductRequestPart::findOrFail($id);
        $sparePartRequest->update($data);

        return redirect()->route('spare-parts.index', $id)
            ->with('success', 'Person assigned successfully.');
    }
}
