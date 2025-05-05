<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\billdetail;
use App\Models\expensedetail;
use App\Models\operator;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class BILLCONTROLLER extends Controller
{
    public function getbill(Request $request)
    {
        // $cusnames = Customer::distinct()->pluck('name');
        // $count = billdetail::count() + 1;
        $count = billdetail::max('BillNo') + 1;
        // dd($count);
        $cusnames = Customer::pluck('name');
        $oprnames = operator::pluck('name');
        $vehiids = Vehicle::pluck('VehiID');


        return view('Billing', compact('cusnames', 'oprnames', 'vehiids', 'count'));
    }



    public function getbillall(Request $request)
    {
        $chk  = $request->type;
        $query = billdetail::query();
        $totalQuery = clone $query;

        $TotAmnt = $totalQuery->sum('TotalAmount');
        $TotPaid = $totalQuery->sum('Paid');
        $TotBal = $totalQuery->sum('Balance');

        $billall = billdetail::paginate(10);
        $cusnames = Customer::pluck('name');


        $html = view('partials.billall-pagination', compact('billall'))->render();
        return view('BillingAll', compact('billall', 'cusnames', 'html', 'TotAmnt','TotPaid','TotBal'));
    }

    public function getbillallNew(Request $request)
    {
        $type = $request->type;
        $from = $request->fromdate;
        $to = $request->todate;
        $cusname = $request->cusname;


        // Example logic based on input
        $query = billdetail::query();

        if ($type === 'DateWise' && $from && $to) {
            $query->whereBetween('BillDate', [$from, $to]);
        } elseif ($type === 'CusWise' && $cusname) {
            // $query->where('CusName', 'like', '%' . $cusname . '%');
            $query->where('CusName', $cusname);
        } elseif ($type === 'Balencewise') {

            $query->where('Balance', '!=', 0);
        }

        $totqry = clone $query;


        $billall = $query->paginate(3);
        $html = view('partials.billall-pagination', compact('billall'))->render();
        return response()->json([
            'html' => $html,
            'type' => $type,
            'billall' => $billall,
            'totals' => [
                'TotalAmount' => $totqry->sum('TotalAmount'),
                'Paid' => $totqry->sum('Paid'),
                'Balance' => $totqry->sum('Balance'),
            ]
        ]);
    }



    public function getCustomerDetails(Request $request)
    {

        $customer = customer::where('name', $request->customer_name)->first();
        // Log::info('Customer Data:', ['customer' => $customer]); 
        if ($customer) {
            return response()->json([
                'mobno' => $customer->mobno,
                'address' => $customer->address
            ]);
        }

        return response()->json(null);
    }

    public function storebill(Request $request)
    {
        // dd( $request);
        billdetail::create([
            // 'name' => $request->name ?: null, // Converts empty string to NULL
            'BillNo' => $request->bill_no,
            'BillDate' => $request->date,
            'CusName' => $request->customer_name,
            'CusMobNo' => $request->cusmob,
            'CusAddress' => $request->cusadd,
            'OprName' => $request->operator_name,
            'VehiID' => $request->vehicle_id,
            'Works' => $request->works,
            'StartTime' => $request->starttime,
            'EndTime' => $request->endtime,
            'TotalTime' => $request->totaltime,
            'TotalAmount' => $request->totamt,
            'Paid' => $request->paid,
            'Balance' => $request->balamt,

        ]);

        return redirect()->back()->with('success', 'Bill Created Successfully!');
    }

    public function getBillData($bill_no)
    {
        $bill = billdetail::where('BillNo', $bill_no)->first();

        if ($bill) {
            return response()->json([
                'CusName' => $bill->CusName,
                'CusMobNo' => $bill->CusMobNo,
                'CusAddress' => $bill->CusAddress,
                'OprName' => $bill->OprName,
                'VehiID' => $bill->VehiID,
                'Works' => $bill->Works,
                'StartTime' => $bill->StartTime,
                'EndTime' => $bill->EndTime,
                'TotalTime' => $bill->TotalTime,
                'TotalAmount' => $bill->TotalAmount,
                'Paid' => $bill->Paid,
                'Balance' => $bill->Balance,
            ]);
        } else {
            return response()->json(['error' => 'Bill not found'], 404);
        }
    }

    public function billupdate(Request $request)
    {

        // $bill = billdetail::find($request->billnum);
        $bill = billdetail::where('BillNo', $request->billnum)->first();
        $curtobeamt = $request->input('curtobeamt');
        $curbalamt = $request->input('curbalamt');
        $existingPaid = $bill->Paid;

        $bill->update([
            'Paid' => $existingPaid +  $curtobeamt,
            'Balance' =>  $curbalamt,
            'Balance' => $request->curbalamt
        ]);

        return response()->json(['message' => 'Bill updated successfully!', 'success' => true]);
        // return response()->json(['bill_no' => $bill ]);
        // $billNo = $request->input('billnum');
        // $curtobeamt = $request->input('curtobeamt');

    }

    public function billDelete(Request $request)
    {
        $bill = billdetail::where('BillNo', $request->billnum)->first();


        if (!$bill) {
            return response()->json(['message' => 'Bill not found!'], 404);
        }

        $bill->delete();
        return response()->json(['message' => 'Customer deleted successfully!', 'success' => true]);
    }

    public function ExpenseEntry(Request $request)
    {
        $expenses = expensedetail::orderBy('BillDate', 'desc')->paginate(10);
        $oprnames = operator::pluck('name');
        $vehiids = Vehicle::pluck('VehiID');

        // dd($oprnames, $vehiids);


        return view('ExpenseEntry', compact('oprnames', 'vehiids', 'expenses'));
    }



    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'date' => 'required|date',
            'entity' => 'required|string',
            'head' => 'nullable|string',
            'totamt' => 'required|numeric|min:0',
        ]);



        // Store data in database
        expensedetail::create([
            'BillDate' => $validated['date'],
            'oprvehiid' => $validated['entity'],
            'head' => $validated['head'],
            'ExpAmt' => $validated['totamt'],
        ]);

        // Redirect with success and chkFlag
        return redirect()->back()->with('success', 'Expense added successfully!');
        // return redirect('/')->with('success', 'Expense added successfully!');

    }



    // public function update(Request $request, $id)
    // {
    //     $expense = expensedetail::findOrFail($id);
    //     $expense->update($request->only(['BillDate', 'oprvehiid', 'head', 'ExpAmt']));
    //     return response()->json(['message' => 'Updated']);
    // }
    public function destroy($id)
    {
        expensedetail::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }


    public function getincomeexpense(Request $request)
    {
        // $paidTotal = billdetail::sum('Paid');
        // $expenseTotal = expensedetail::sum('ExpAmt');
        // $profit = $paidTotal - $expenseTotal;

        $paidTotal = 0;
        $expenseTotal = 0;
        $profit = $paidTotal - $expenseTotal;


        return view('IncomeExpense', compact('paidTotal', 'expenseTotal', 'profit'));
    }

    public function getExpenseDateWise(Request $request)
    {

        $from = $request->fromdate;
        $to = $request->todate;



        // Example logic based on input
        $incall = billdetail::whereBetween('BillDate', [$from, $to]);
        $expall = expensedetail::whereBetween('BillDate', [$from, $to]);

        return response()->json([

            'incall' => $incall->sum('Paid'),
            'expall' => $expall->sum('ExpAmt'),
            'profit' => $incall->sum('Paid') - $expall->sum('ExpAmt'),

        ]);
    }

    public function getvehireport(Request $request)
    {
        $vehiids = Vehicle::pluck('VehiID');
        $billall = billdetail::where('id', 0)->paginate(10); // no record will match
        return view('VehicleReports', compact('vehiids', 'billall'));
    }

    public function gettotvehichk(Request $request)
    {
        $type = $request->type;
        $from = $request->fromdate;
        $to = $request->todate;
        $vehiid = $request->vehiid;


        if ($type === "totchk") {
            $query = billdetail::query();
            $query->whereBetween('BillDate', [$from, $to])
                ->where('VehiID', $vehiid);
            $totalQuery = clone $query;

            $billall = $query->paginate(10);
            $TotTime = $totalQuery->sum('TotalTime');

            $tableHtml = view('partials.totchk-table-rows', compact('billall', 'TotTime'))->render();
            $paginationHtml = view('partials.totchk-pagination', compact('billall'))->render();
        } else {
            $query = expensedetail::query(); // Assuming you use a different model here
            $query->whereBetween('BillDate', [$from, $to])
                ->where('oprvehiid', $vehiid);
            $totalQuery = clone $query;

            $expall = $query->paginate(10);
            $TotalAmount = $totalQuery->sum('ExpAmt');

            $tableHtml = view('partials.expchk-table-rows', compact('expall', 'TotalAmount'))->render();
            $paginationHtml = view('partials.expchk-pagination', compact('expall'))->render();
        }


        return response()->json([
            'tableHtml' => $tableHtml,
            'paginationHtml' => $paginationHtml
        ]);
    }
}
