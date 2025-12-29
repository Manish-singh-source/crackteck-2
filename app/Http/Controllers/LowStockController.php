<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LowStockController extends Controller
{
    /**
     * Display low stock alert page for CRM.
     */
    public function index()
    {
        $lowStockProducts = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->where('stock_quantity', '<', 40)
            ->where('status', 'Active')
            ->orderBy('stock_quantity', 'asc')
            ->get();

        return view('/crm/accounts/low-stock-alert', compact('lowStockProducts'));
    }

    /**
     * Display low stock alert page for warehouse.
     */
    public function warehouse_index()
    {
        $lowStockProducts = Product::with(['brand', 'parentCategorie', 'subCategorie', 'warehouse'])
            ->where('stock_quantity', '<', 40)
            ->where('status', 'Active')
            ->orderBy('stock_quantity', 'asc')
            ->get();

        return view('/warehouse/low-stock-alert/index', compact('lowStockProducts'));
    }
}
