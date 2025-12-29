<?php

namespace App\Http\Controllers;

use App\Models\AmcServiceVisit;
use App\Models\AmcVisitEngineerAssignment;
use App\Models\Engineer;
use App\Models\QuickServiceEngineerAssignment;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EngineerController extends Controller
{
    //
    public function index()
    {
        $engineers = Staff::with('workSkills', 'policeVerification')->where('staff_role', '1')->get();

        // dd($engineers);
        return view('/crm/engineers/index', compact('engineers'));
    }

    public function create()
    {
        return view('/crm/access-control/staff/create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:engineers,email',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $engineer = new Engineer;
        $engineer->first_name = $request->first_name;
        $engineer->last_name = $request->last_name;
        $engineer->phone = $request->phone;
        $engineer->email = $request->email;
        $engineer->dob = $request->dob;
        $engineer->gender = $request->gender;

        $engineer->address = $request->address;
        $engineer->address2 = $request->address2;
        $engineer->city = $request->city;
        $engineer->state = $request->state;
        $engineer->country = $request->country;
        $engineer->pincode = $request->pincode;

        $engineer->bank_acc_holder_name = $request->bank_acc_holder_name;
        $engineer->bank_acc_number = $request->bank_acc_number;
        $engineer->bank_name = $request->bank_name;
        $engineer->ifsc_code = $request->ifsc_code;

        $engineer->police_verification = $request->police_verification;
        $engineer->police_verification_status = $request->police_verification_status;
        // $engineer->police_certificate = $request->police_certificate;
        if ($request->hasFile('police_certificate')) {
            $file = $request->file('police_certificate');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/engineer/police_certificate'), $filename);
            $engineer->police_certificate = 'uploads/crm/engineer/police_certificate/'.$filename;
        }

        $engineer->designation = $request->designation;
        $engineer->department = $request->department;
        $engineer->join_date = $request->join_date;

        $engineer->primary_skills = $request->primary_skills;
        // $engineer->pic = $request->pic;
        if ($request->hasFile('pic')) {
            $file = $request->file('pic');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/engineer/pic'), $filename);
            $engineer->pic = 'uploads/crm/engineer/pic/'.$filename;
        }

        // Aadhar Card
        if ($request->hasFile('aadhar_pic')) {
            $file = $request->file('aadhar_pic');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/engineer/aadhar_pic'), $filename);
            $engineer->aadhar_pic = 'uploads/crm/engineer/aadhar_pic/'.$filename;
        }

        // Pan Card
        if ($request->hasFile('pan_card')) {
            $file = $request->file('pan_card');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/engineer/pan_card'), $filename);
            $engineer->pan_card = 'uploads/crm/engineer/pan_card/'.$filename;
        }

        $engineer->save();

        if (! $engineer) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('engineers.index')->with('success', 'Customer added successfully.');
    }

    public function view($id)
    {
        $engineer = Staff::find($id);

        // Get all visit assignments for this engineer (Active, Transferred, and Completed)
        $visitAssignments = AmcVisitEngineerAssignment::with([
            'visit.amcService.amcPlan',
            'visit.amcService.branches',
            'engineer',
            'supervisor',
            'groupMembers.engineer',
            'transferredToAssignment.engineer',
            'transferredToAssignment.supervisor',
            'transferredToAssignment.groupMembers.engineer',
        ])
            ->where(function ($query) use ($id) {
                // Individual assignments
                $query->where('engineer_id', $id)
                    ->where('assignment_type', 'Individual');
            })
            ->orWhereHas('groupMembers', function ($query) use ($id) {
                // Group assignments where engineer is a member
                $query->where('engineer_id', $id);
            })
            ->whereIn('status', ['Active', 'Transferred', 'Completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all Quick Service Request assignments for this engineer
        $quickServiceAssignments = QuickServiceEngineerAssignment::with([
            'quickServiceRequest.quickService',
            'quickServiceRequest.customer',
            'engineer',
            'supervisor',
            'groupEngineers',
        ])
            ->where(function ($query) use ($id) {
                // Individual assignments
                $query->where('engineer_id', $id)
                    ->where('assignment_type', 'Individual');
            })
            ->orWhereHas('groupEngineers', function ($query) use ($id) {
                // Group assignments where engineer is a member
                $query->where('engineer_id', $id);
            })
            ->whereIn('status', ['Active', 'Transferred', 'Completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all NON AMC Service assignments for this engineer
        $nonAmcAssignments = \App\Models\NonAmcEngineerAssignment::with([
            'nonAmcService',
            'engineer',
            'supervisor',
            'groupMembers.engineer',
            'transferredToAssignment.engineer',
            'transferredToAssignment.supervisor',
            'transferredToAssignment.groupMembers.engineer',
        ])
            ->where(function ($query) use ($id) {
                // Individual assignments
                $query->where('engineer_id', $id)
                    ->where('assignment_type', 'Individual');
            })
            ->orWhereHas('groupMembers', function ($query) use ($id) {
                // Group assignments where engineer is a member
                $query->where('engineer_id', $id);
            })
            ->whereIn('status', ['Active', 'Transferred', 'Completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('crm/engineers/view', compact('engineer', 'visitAssignments', 'quickServiceAssignments', 'nonAmcAssignments'));
    }

    /**
     * Display visit detail page
     */
    public function visitDetail($id)
    {
        $visit = AmcServiceVisit::with([
            'amcService.amcPlan',
            'amcService.branches',
            'amcService.products.type',
            'amcService.products.brand',
            'engineer',
            'activeAssignment.engineer',
            'activeAssignment.supervisor',
            'activeAssignment.groupMembers.engineer',
            'engineerAssignments.engineer',
            'engineerAssignments.supervisor',
            'engineerAssignments.groupMembers.engineer',
        ])->findOrFail($id);

        return view('crm/engineers/visit-detail', compact('visit'));
    }

    public function edit($id)
    {
        $engineer = Engineer::find($id);

        return view('/crm/engineers/edit', compact('engineer'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $engineer = Engineer::findOrFail($id);
        $engineer->first_name = $request->first_name;
        $engineer->last_name = $request->last_name;
        $engineer->phone = $request->phone;
        $engineer->email = $request->email;
        $engineer->dob = $request->dob;
        $engineer->gender = $request->gender;

        $engineer->address = $request->address;
        $engineer->address2 = $request->address2;
        $engineer->city = $request->city;
        $engineer->state = $request->state;
        $engineer->country = $request->country;
        $engineer->pincode = $request->pincode;

        $engineer->bank_acc_holder_name = $request->bank_acc_holder_name;
        $engineer->bank_acc_number = $request->bank_acc_number;
        $engineer->bank_name = $request->bank_name;
        $engineer->ifsc_code = $request->ifsc_code;

        $engineer->police_verification = $request->police_verification;
        $engineer->police_verification_status = $request->police_verification_status;
        if ($request->hasFile('police_certificate')) {

            // Only if updating profile
            if ($engineer->police_certificate != '') {
                if (File::exists(public_path($engineer->police_certificate))) {
                    File::delete(public_path($engineer->police_certificate));
                }
            }
            // updating profile end

            $file = $request->file('police_certificate');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/engineer/police_certificate'), $filename);
            $engineer->police_certificate = 'uploads/crm/engineer/police_certificate/'.$filename;
        }

        $engineer->designation = $request->designation;
        $engineer->department = $request->department;
        $engineer->join_date = $request->join_date;

        $engineer->primary_skills = $request->primary_skills;
        if ($request->hasFile('pic')) {

            // Only if updating profile
            if ($engineer->pic != '') {
                if (File::exists(public_path($engineer->pic))) {
                    File::delete(public_path($engineer->pic));
                }
            }
            // updating profile end

            $file = $request->file('pic');
            $filename = time().'.'.$file->getClientOriginalExtension();
            // dd($filename);

            $file->move(public_path('uploads/crm/engineer/pic'), $filename);
            $engineer->pic = 'uploads/crm/engineer/pic/'.$filename;
        }

        $engineer->save();

        return redirect()->route('engineers.index')->with('success', 'Engineer updated successfully.');
    }

    public function delete($id)
    {
        $engineer = Engineer::findOrFail($id);
        $engineer->delete();

        return redirect()->route('engineers.index')->with('success', 'Customer deleted successfully.');
    }
}
