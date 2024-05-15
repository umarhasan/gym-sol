<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;

class ExpensesController extends AdminBaseController

{
    public function index()
    {

        $currentMonth = Expense::where('club_id', auth()->user()->club_id)
            ->whereMonth('date', '=', now()->month)
            ->orderByDesc('id')
            ->get();

        $expensesToday = Expense::where('club_id', auth()->user()->club_id)
            ->whereDate('date', Carbon::today())
            ->orderByDesc('id')
            ->get();
            
        $lastSevenDays = Expense::where('club_id', auth()->user()->club_id)
            ->where('date', '>=', now()->subDays(7))
            ->orderByDesc('id')
            ->get();
        return view('expenses.index', [
            'expenses' => $currentMonth,
            'expensesToday' => $expensesToday,
            'expensesLast7Days' => $lastSevenDays
        ]);
    }
    
    public function create(){
        return view('expenses.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'amount' => 'required',
            'expense_by' => 'required',
            'date' => 'required',
            'paid_to' => 'required',
            'details' => 'required',
        ]);
    
        $data = [
            'amount' => $request->amount,
            'expense_by' => $request->expense_by,
            'date' => Carbon::parse($request->date),
            'details' => $request->details,
            'paid_to' => $request->paid_to,
            'club_id' => auth()->user()->club_id,
            'created_by' => auth()->user()->id,
        ];
    
        // Check if an expense with the same details already exists
        $existingExpense = Expense::where('amount', $data['amount'])
        ->where('expense_by', $data['expense_by'])
        ->where('date', $data['date'])
        ->where('details', $data['details'])
        ->where('paid_to', $data['paid_to'])
        ->where('club_id', $data['club_id'])
        ->first();
    
        if ($existingExpense) {
            session()->flash('expense-already-exists', ['title' => 'Duplicate Entry', 'body' => 'Expense with similar details already exists.']);
        } else {
            // Insert the expense into the database
            $string = $data['paid_to'] . '-' . Carbon::now()->format('F-H:i');
            $invoice_url = strtoupper($string);
            $data['invoice_url'] = $invoice_url;
    
            $id = DB::table('expenses')->insertGetId($data);
            session()->flash('expenses-registered-successfully', ['title' => 'Well done!', 'body' => 'You have successfully added the expense.']);
        }
    
        return redirect()->route('expenses.index');
    }


    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
            'expense_by' => 'required',
            'date' => 'required',
            'paid_to' => 'required',
            'details' => 'required',
        ]);

        $expense = Expense::findOrFail($id);

        $expense->amount = $request->amount;
        $expense->expense_by = $request->expense_by;
        $expense->date = Carbon::parse($request->date);
        $expense->details = $request->details;
        $expense->paid_to = $request->paid_to;

    
        $expense->save();

        session()->flash('expense-updated-successfully', ['title' => 'Success', 'body' => 'Expense updated successfully.']);

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        session()->flash('members-registered-successfully', ['title' => 'Done!', 'body' => 'You have successfully deleted an expense']);

        return redirect()->route('expenses.index');
    }

    public function ExpensesInvoice($id){

        $expense = Expense::findOrFail($id); // or use your preferred method to retrieve the expense
        $setting = DB::table('clubs')->where('id', $expense->club_id)->first();
       
        return view('expenses.expenses-invoice',['clubSetting' => $setting, 'data' => $expense]);
    }
}
