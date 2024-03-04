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
            ->when($this->search, function ($query) {
                $query->where('expense_by', 'like', '%' . $this->search . '%')
                      ->orWhere('amount', 'like', '%' . $this->search . '%');
            })
            ->whereMonth('date', '=', now()->month)
            ->orderByDesc('id')
            ->paginate(10);

        $expensesToday = Expense::where('club_id', auth()->user()->club_id)
            ->whereDate('date', Carbon::today())
            ->orderByDesc('id')
            ->paginate(10);

        $lastSevenDays = Expense::where('club_id', auth()->user()->club_id)
            ->where('date', '>=', now()->subDays(7))
            ->orderByDesc('id')
            ->paginate(10);

        return view('expenses.index', [
            'expenses' => $currentMonth,
            'expensesToday' => $expensesToday,
            'expensesLast7Days' => $lastSevenDays
        ]);
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

        $expense = new Expense();
        $expense->amount = $request->amount;
        $expense->expense_by = $request->expense_by;
        $expense->date = Carbon::parse($request->date);
        $expense->details = $request->details;
        $expense->paid_to = $request->paid_to;
        $expense->club_id = auth()->user()->club_id;
        $expense->save();

        session()->flash('expenses-registered-successfully', ['title' => 'Well done!', 'body' => 'You have successfully added the expense.']);

        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'amount' => 'required',
            'expense_by' => 'required',
            'date' => 'required',
            'paid_to' => 'required',
            'details' => 'required',
        ]);

        $expense->amount = $request->amount;
        $expense->expense_by = $request->expense_by;
        $expense->date = Carbon::parse($request->date);
        $expense->details = $request->details;
        $expense->paid_to = $request->paid_to;
        $expense->save();

        session()->flash('expenses-registered-successfully', ['title' => 'Well done!', 'body' => 'Your have successfully updated the expense.']);

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        session()->flash('members-registered-successfully', ['title' => 'Done!', 'body' => 'You have successfully deleted an expense']);

        return redirect()->route('expenses.index');
    }
}
