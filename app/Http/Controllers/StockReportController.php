<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StockReportController extends Controller
{
    public function index()
    {
        // stock report page
        $stockReports = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('crm/accounts/stock-request/index', compact('stockReports'));
    }

    public function warehouseIndex()
    {
        // stock report page
        $stockReports = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('warehouse/stock-reports/index', compact('stockReports'));
    }
}
