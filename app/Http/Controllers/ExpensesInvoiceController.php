<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Club;

class ExpensesInvoiceController extends AdminBaseController
{
    public $expensesId;

    public function mount($id)
    {
        $this->expensesId = $id;
    }

    public function index()
    {
        $expense = Expense::findOrFail($this->expensesId);
        $setting = Club::findOrFail($expense->club_id);

        return view('expenses.expenses-invoice', ['clubSetting' => $setting, 'data' => $expense]);
    }
}