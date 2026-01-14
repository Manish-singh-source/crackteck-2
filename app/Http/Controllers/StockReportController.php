<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequestRequest;
use App\Models\Product;
use App\Models\StockRequest;
use App\Models\StockRequestItem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class StockReportController extends Controller
{

    public function index()
    {
        // stock report page
        $stockReports = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('warehouse/stock-reports/index', compact('stockReports'));
    }

}
