<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesPersonController extends Controller
{
    //
    public function index()
    {
        $sales_persons = \App\Models\SalesPerson::all();

        return view('/crm/sales-person/index', compact('sales_persons'));
    }

    public function create()
    {
        return view('/crm/sales-person/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:sales_people,email',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sales_person = new \App\Models\SalesPerson;
        $sales_person->first_name = $request->first_name;
        $sales_person->last_name = $request->last_name;
        $sales_person->phone = $request->phone;
        $sales_person->email = $request->email;
        $sales_person->dob = $request->dob;
        $sales_person->gender = $request->gender;

        $sales_person->current_address = $request->current_address;
        $sales_person->city = $request->city;
        $sales_person->state = $request->state;
        $sales_person->country = $request->country;
        $sales_person->pincode = $request->pincode;

        $sales_person->employment_type = $request->employment_type;
        $sales_person->assigned_area = $request->assigned_area;
        $sales_person->joining_date = $request->join_date;

        $sales_person->police_verification = $request->police_verification;
        $sales_person->police_verification_status = $request->police_verification_status;
        $sales_person->police_certificate = $request->police_certificate;

        $sales_person->govid = $request->govid;
        $sales_person->idno = $request->idno;
        $sales_person->adhar_pic = $request->adhar_pic;

        $sales_person->bank_acc_no = $request->bank_acc_no;
        $sales_person->bank_name = $request->bank_name;
        $sales_person->ifsc_code = $request->ifsc_code;
        $sales_person->passbook_pic = $request->passbook_pic;

        $sales_person->status = $request->status;

        $sales_person->save();

        if (! $sales_person) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('sales-person.index')->with('success', 'Sales Person added successfully.');
    }

    public function view($id)
    {
        $sales_person = \App\Models\SalesPerson::find($id);

        return view('/crm/sales-person/view', compact('sales_person'));
    }

    public function edit($id)
    {
        $sales_person = \App\Models\SalesPerson::find($id);

        return view('/crm/sales-person/edit', compact('sales_person'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sales_person = \App\Models\SalesPerson::find($id);
        $sales_person->first_name = $request->first_name;
        $sales_person->last_name = $request->last_name;
        $sales_person->phone = $request->phone;
        $sales_person->email = $request->email;
        $sales_person->dob = $request->dob;
        $sales_person->gender = $request->gender;

        $sales_person->current_address = $request->current_address;
        $sales_person->city = $request->city;
        $sales_person->state = $request->state;
        $sales_person->country = $request->country;
        $sales_person->pincode = $request->pincode;

        $sales_person->employment_type = $request->employment_type;
        $sales_person->assigned_area = $request->assigned_area;
        $sales_person->joining_date = $request->join_date;

        $sales_person->police_verification = $request->police_verification;
        $sales_person->police_verification_status = $request->police_verification_status;
        $sales_person->police_certificate = $request->police_certificate;

        $sales_person->govid = $request->govid;
        $sales_person->idno = $request->idno;
        $sales_person->adhar_pic = $request->adhar_pic;

        $sales_person->bank_acc_no = $request->bank_acc_no;
        $sales_person->bank_name = $request->bank_name;
        $sales_person->ifsc_code = $request->ifsc_code;
        $sales_person->passbook_pic = $request->passbook_pic;

        $sales_person->status = $request->status;

        $sales_person->save();

        return redirect()->route('sales-person.index')->with('success', 'Sales Person updated successfully.');
    }

    public function delete($id)
    {
        // dd($request->all());
    }
}
