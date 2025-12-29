<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Delivery extends Controller
{
    //
    public function index()
    {
        $delivery = DeliveryMan::all();

        return view('/crm/delivery-man/index', compact('delivery'));
    }

    public function create()
    {
        return view('/crm/delivery-man/create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:delivery_men,email',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $delivery = new DeliveryMan;
            $delivery->first_name = $request->first_name;
            $delivery->last_name = $request->last_name;
            $delivery->phone = $request->phone;
            $delivery->email = $request->email;
            $delivery->dob = $request->dob;
            $delivery->gender = $request->gender;

            $delivery->current_address = $request->current_address;
            $delivery->city = $request->city;
            $delivery->state = $request->state;
            $delivery->country = $request->country;
            $delivery->pincode = $request->pincode;

            $delivery->employment_type = $request->employment_type;
            $delivery->joining_date = $request->joining_date;
            $delivery->assigned_area = $request->assigned_area;

            $delivery->vehicle_type = $request->vehicle_type;
            $delivery->vehical_no = $request->vehical_no;
            $delivery->driving_license_no = $request->driving_license_no;
            // $delivery->driving_license = $request->driving_license;
            if ($request->hasFile('driving_license')) {
                $file = $request->file('driving_license');
                $filename = time().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/crm/delivery_man/driving_license'), $filename);
                $delivery->driving_license = 'uploads/crm/delivery_man/driving_license/'.$filename;
            }

            $delivery->police_verification = $request->police_verification;
            $delivery->police_verification_status = $request->police_verification_status;
            // $delivery->police_certificate = $request->police_certificate;
            if ($request->hasFile('police_certificate')) {
                $file = $request->file('police_certificate');
                $filename = time().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/crm/delivery_man/police_certificate'), $filename);
                $delivery->police_certificate = 'uploads/crm/delivery_man/police_certificate/'.$filename;
            }

            $delivery->govid = $request->govid;
            $delivery->idno = $request->idno;
            // $delivery->adhar_pic = $request->adhar_pic;
            if ($request->hasFile('adhar_pic')) {
                $file = $request->file('adhar_pic');
                $filename = time().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/crm/delivery_man/adhar_pic'), $filename);
                $delivery->adhar_pic = 'uploads/crm/delivery_man/adhar_pic/'.$filename;
            }

            $delivery->bank_acc_no = $request->bank_acc_no;
            $delivery->bank_name = $request->bank_name;
            $delivery->ifsc_code = $request->ifsc_code;
            // $delivery->passbook_pic = $request->passbook_pic;
            if ($request->hasFile('passbook_pic')) {
                $file = $request->file('passbook_pic');
                $filename = time().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/crm/delivery_man/passbook_pic'), $filename);
                $delivery->passbook_pic = 'uploads/crm/delivery_man/passbook_pic/'.$filename;
            }
            $delivery->status = $request->status;

            $delivery->save();
        } catch (Exception $e) {
            dd($e);
        }

        if (! $delivery) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('delivery-man.index')->with('success', 'Delivery Man added successfully.');
    }

    public function view($id)
    {
        $delivery = DeliveryMan::find($id);

        return view('crm/delivery-man/view', compact('delivery'));
    }

    public function edit($id)
    {
        $delivery = DeliveryMan::find($id);

        return view('/crm/delivery-man/edit', compact('delivery'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $delivery = DeliveryMan::findOrFail($id);
        $delivery->first_name = $request->first_name;
        $delivery->last_name = $request->last_name;
        $delivery->phone = $request->phone;
        $delivery->email = $request->email;
        $delivery->dob = $request->dob;
        $delivery->gender = $request->gender;

        $delivery->current_address = $request->current_address;
        $delivery->city = $request->city;
        $delivery->state = $request->state;
        $delivery->country = $request->country;
        $delivery->pincode = $request->pincode;

        $delivery->employment_type = $request->employment_type;
        $delivery->joining_date = $request->joining_date;
        $delivery->assigned_area = $request->assigned_area;

        $delivery->vehicle_type = $request->vehicle_type;
        $delivery->vehical_no = $request->vehical_no;
        $delivery->driving_license_no = $request->driving_license_no;
        // $delivery->driving_license = $request->driving_license;

        if ($request->hasFile('driving_license')) {

            // Only if updating profile
            if ($delivery->driving_license != '') {
                if (File::exists(public_path($delivery->driving_license))) {
                    File::delete(public_path($delivery->driving_license));
                }
            }
            // updating profile end

            $file = $request->file('driving_license');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/crm/delivery_man/driving_license'), $filename);
            $delivery->driving_license = 'uploads/crm/delivery_man/driving_license/'.$filename;
        }

        $delivery->police_verification = $request->police_verification;
        $delivery->police_verification_status = $request->police_verification_status;

        if ($request->hasFile('police_certificate')) {

            // Only if updating profile
            if ($delivery->police_certificate != '') {
                if (File::exists(public_path($delivery->police_certificate))) {
                    File::delete(public_path($delivery->police_certificate));
                }
            }
            // updating profile end

            $file = $request->file('police_certificate');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/crm/delivery_man/police_certificate'), $filename);
            $delivery->police_certificate = 'uploads/crm/delivery_man/police_certificate/'.$filename;
        }

        $delivery->govid = $request->govid;
        $delivery->idno = $request->idno;

        if ($request->hasFile('adhar_pic')) {

            // Only if updating profile
            if ($delivery->adhar_pic != '') {
                if (File::exists(public_path($delivery->adhar_pic))) {
                    File::delete(public_path($delivery->adhar_pic));
                }
            }
            // updating profile end

            $file = $request->file('adhar_pic');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/crm/delivery_man/adhar_pic'), $filename);
            $delivery->adhar_pic = 'uploads/crm/delivery_man/adhar_pic/'.$filename;
        }

        $delivery->bank_acc_no = $request->bank_acc_no;
        $delivery->bank_name = $request->bank_name;
        $delivery->ifsc_code = $request->ifsc_code;
        // $delivery->passbook_pic = $request->passbook_pic;
        if ($request->hasFile('passbook_pic')) {

            // Only if updating profile
            if ($delivery->passbook_pic != '') {
                if (File::exists(public_path($delivery->passbook_pic))) {
                    File::delete(public_path($delivery->passbook_pic));
                }
            }
            // updating profile end

            $file = $request->file('passbook_pic');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/crm/delivery_man/passbook_pic'), $filename);
            $delivery->passbook_pic = 'uploads/crm/delivery_man/passbook_pic/'.$filename;
        }
        $delivery->status = $request->status;

        $delivery->save();

        return redirect()->route('delivery-man.index')->with('success', 'Delivery Man updated successfully.');
    }

    public function delete($id)
    {
        $delivery = DeliveryMan::findOrFail($id);
        $delivery->delete();

        return redirect()->route('delivery-man.index')->with('success', 'Delivery Man deleted successfully.');
    }
}
