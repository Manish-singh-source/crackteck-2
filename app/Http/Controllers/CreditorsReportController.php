<?php

namespace App\Http\Controllers;

class CreditorsReportController extends Controller
{
    //
    public function index()
    {
        return view('/crm/accounts/creditors-report/index');
    }
}
