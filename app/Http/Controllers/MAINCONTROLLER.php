<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\operator;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MAINCONTROLLER extends Controller
{

    public function redirectToDashboard()
    {
        return redirect()->route('dashboard');
    }


    public function cusentry(Request $request)
    {


        //  dd($request->all());

        // $request->validate([
        //     'name' => 'required|string|max:255', // Changed from 'fullName' to 'name'
        //     'mobno' => 'required|string|max:255',
        //     'address'=>'required|text',

        // ]);

        customer::create([
            'name' => $request->name, // Correct field name
            // 'name' => $request->name ?: null, // Converts empty string to NULL
            'mobno' => $request->mobno,
            'address' => $request->address,
        ]);

        // return "Admission Form Submitted Successfully!";
        // return redirect()->back()->with('success', 'Customer Created Successfully!');
        return response()->json(['success' => 'Customer created successfully!']);

    }


    public function oprentry(Request $request)
    {


        //  dd($request->all());

        // $request->validate([
        //     'name' => 'required|string|max:255', // Changed from 'fullName' to 'name'
        //     'mobno' => 'required|string|max:255',
        //     'address'=>'required|text',

        // ]);

        operator::create([
            'name' => $request->name, // Correct field name
            // 'name' => $request->name ?: null, // Converts empty string to NULL
            'mobno' => $request->mobno,
            'address' => $request->address,
        ]);

        // return "Admission Form Submitted Successfully!";
        return redirect()->back()->with('success', 'Operator Created Successfully!');
    }



    public function Vehientry(Request $request)
    {


        //  dd($request->all());

        // $request->validate([
        //     'name' => 'required|string|max:255', // Changed from 'fullName' to 'name'
        //     'mobno' => 'required|string|max:255',
        //     'address'=>'required|text',

        // ]);

        Vehicle::create([
            'VehiID' => $request->VehiNo, // Correct field name
            // 'name' => $request->name ?: null, // Converts empty string to NULL
            'VehiName' => $request->Vehiname,

        ]);

        // return "Admission Form Submitted Successfully!";
        return redirect()->back()->with('success', 'Vehicle Created Successfully!');
    }





    public function getcus(Request $request)
    {
        $cusall = customer::paginate(10); // Fetch all student results
        // dd($cusall);
        return view('customerEntry', compact('cusall'));
    }


    public function getopr(Request $request)
    {
        $oprall = operator::paginate(10);  // Fetch all student results
        // dd($cusall);
        return view('OperatorEntry', compact('oprall'));
    }


    public function getVehi(Request $request)
    {
        $VehiAll = Vehicle::paginate(10);// Fetch all student results
        // dd($cusall);
        // dd($VehiAll);
        return view('VehicleEntry', compact('VehiAll'));
    }


    public function fetchCustomer(Request $request)
    {

        $customer = Customer::where('mobno', $request->mobno)->first();
        // $customer = Customer::where('mobno', 'like', '%' . $request->mobno . '%')->first();
        
        if ($customer) {
            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'mobno' => $customer->mobno,
                    'address' => $customer->address
                ]
            ]);
        } else {
            // Fetch all customers if no match is found
            $allCustomers = Customer::all();

            return response()->json([
                'success' => false,
                'customers' => $allCustomers
            ]);
        }
    }



    public function fetchoperator(Request $request)
    {

        $operator = operator::where('mobno', $request->mobno)->first();
        // $customer = Customer::where('mobno', 'like', '%' . $request->mobno . '%')->first();


        if ($operator) {
            return response()->json([
                'success' => true,
                'operator' => [
                    'id' => $operator->id,
                    'name' => $operator->name,
                    'mobno' => $operator->mobno,
                    'address' => $operator->address
                ]
            ]);
        } else {
            // Fetch all customers if no match is found
            $alloperators = operator::all();

            return response()->json([
                'success' => false,
                'operators' => $alloperators
            ]);
        }
    }



    public function fetchVehicle(Request $request)
    {

        $vehicle = Vehicle::where('VehiID', $request->vehino)->first();
        // $customer = Customer::where('mobno', 'like', '%' . $request->mobno . '%')->first();


        if ($vehicle) {
            return response()->json([
                'success' => true,
                'vehicle' => [
                    'id' => $vehicle->id,
                    'VehiID' => $vehicle->VehiID,
                    'VehiName' => $vehicle->VehiName,
                    // 'address' => $vehicle->address
                ]
            ]);
        } else {
            // Fetch all customers if no match is found
            $allvehicles = Vehicle::all();

            return response()->json([
                'success' => false,
                'vehicles' => $allvehicles
            ]);
        }
    }





    public function updatecus(Request $request)
    {
        // Fetch the customer by ID
        $customer = Customer::find($request->id);
        Log::info('Update Request Data:', $request->all());
        // If no customer is found, return an error
        if (!$customer) { // Fix: Changed to if (!$customer)
            return response()->json(['message' => 'Customer not found!'], 404);
        }

        // Update customer data
        $customer->update([
            'name' => $request->name,
            'mobno' => $request->mobno,
            'address' => $request->address
        ]);

        return response()->json(['message' => 'Customer updated successfully!', 'success' => true]);
    }


    public function updatevehi(Request $request)
    {
        // Fetch the customer by ID
        $vehicle = Vehicle::find($request->id);
        // Log::info('Update Request Data:', $request->all());
        // If no customer is found, return an error
        if (!$vehicle) { // Fix: Changed to if (!$customer)
            return response()->json(['message' => 'Vehicle not found!'], 404);
        }

        // Update customer data
        $vehicle->update([
            'VehiID' => $request->vehiid,
            'VehiName' => $request->vehiname,
        ]);

        return response()->json(['message' => 'Vehicle updated successfully!', 'success' => true]);
    }



    public function updateopr(Request $request)
    {
        // Fetch the customer by ID
        $operator = operator::find($request->id);
        Log::info('Update Request Data:', $request->all());
        // If no customer is found, return an error
        if (!$operator) { // Fix: Changed to if (!$customer)
            return response()->json(['message' => 'Operator not found!'], 404);
        }

        // Update customer data
        $operator->update([
            'name' => $request->name,
            'mobno' => $request->mobno,
            'address' => $request->address
        ]);

        return response()->json(['message' => 'Operator updated successfully!', 'success' => true]);
    }



    public function deletecus(Request $request)
    {
        $customer = Customer::find($request->id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found!'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully!', 'success' => true]);
    }

    public function deleteopr(Request $request)
    {
        $operator = operator::find($request->id);

        if (!$operator) {
            return response()->json(['message' => 'Operator not found!'], 404);
        }

        $operator->delete();
        return response()->json(['message' => 'Operator deleted successfully!', 'success' => true]);
    }

    public function deletevehi(Request $request)
    {
        $vehicle = Vehicle::find($request->id);

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found!'], 404);
        }

        $vehicle->delete();
        return response()->json(['message' => 'Vechile deleted successfully!', 'success' => true]);
    }
}
