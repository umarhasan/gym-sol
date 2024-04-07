<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use App\Models\Fees;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{

    public $startDate = '', $endDate = '', $filterBy = 'weekly';

    public function UnpaidMembers()
    {
        $currentMonth = now()->format('m');
        $unPaidMembers = User::leftJoin('fees', function ($join) use ($currentMonth) {
            $join->on('users.id', '=', 'fees.user_id')
                ->whereMonth('fees.date', '=', $currentMonth);
        })
            ->whereNull('fees.id')
            ->select('users.name', 'users.phone', 'users.image', 'users.id as userId', 'fees.*')
            ->where('users.club_id', Auth::user()->club_id)
            ->get();
        return view('reports.unpaid-members', ['unPaidMembers' => $unPaidMembers]);
    }

    public function ExpiredMembers()
    {

        $currentYear = now()->year;

        $expiredMembers = Fees::join('users', 'users.id', '=', 'fees.user_id')
            ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.image', 'fees.id as fee_id') // Include fees.id in the select list
            ->selectRaw('MAX(expiry) as latest_expiration')
            // ->whereYear('expiry', $currentYear)
            ->groupBy('users.id', 'users.name', 'users.email', 'users.phone', 'users.image', 'fee_id') // Group by all selected columns
            ->havingRaw('DATEDIFF(MAX(expiry), NOW()) <= 0')
            ->where('fees.club_id', Auth::user()->club_id)
            ->get();

        return view('reports.expired-members', ['expiredMembers' => $expiredMembers]);
    }

    public function SoonToExpireMembers()
    {
        $currentYear = now()->year;

        $expiredMembers = Fees::select('user_id')
            ->selectRaw('MAX(expiry) as latest_expiration')
            ->whereYear('expiry', $currentYear)
            ->where('club_id', Auth::user()->club_id)
            ->groupBy('user_id')
            ->havingRaw('MAX(expiry) <= NOW()') // Adjusted condition to use MAX function
            ->get();


        $expiredMembersIds = $expiredMembers->pluck('user_id')->toArray();

        $expiringSoon = Fees::join('users', 'users.id', '=', 'fees.user_id')
            ->whereNotIn('user_id', $expiredMembersIds)
            ->whereYear('expiry', $currentYear)
            ->select('users.name', 'users.email', 'users.phone', 'users.image')
            ->selectRaw('MAX(expiry) as latest_expiration')
            ->groupBy('users.id') // Group by users.id instead of user_id
            ->havingRaw('DATEDIFF(MAX(expiry), NOW()) > 1')
            ->havingRaw('DATEDIFF(MAX(expiry), NOW()) <= 8')
            ->where('fees.club_id', Auth::user()->club_id)
            ->get();

        return view('reports.soon-to-expire-members', ['expiringSoon' => $expiringSoon]);
    }
    public function collectionHistory(Request $request)
    {
        $filterBy = $request->input('filterBy');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $collections = User::join('fees', 'fees.user_id', '=', 'users.id')
            ->when($filterBy, function ($query) use ($filterBy, $startDate, $endDate) {
                if ($filterBy === 'weekly') {
                    $query->whereBetween('fees.date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($filterBy === 'monthly') {
                    $query->whereYear('fees.date', Carbon::now()->year)->whereMonth('fees.date', Carbon::now()->month);
                } elseif ($filterBy === 'daily') {
                    $query->whereDate('fees.date', Carbon::today());
                } elseif ($filterBy === 'custom' && $startDate && $endDate) {
                    $query->whereBetween('fees.date', [Carbon::parse($startDate), Carbon::parse($endDate)]);
                }
            })
            ->whereYear('fees.date', Carbon::now()->year)
            ->where('fees.club_id', Auth::user()->club_id)
            ->select('users.name', 'users.image', 'fees.*')
            ->get();

        return view('reports.collection-history', [
            'collections' => $collections,
            'filterBy' => $filterBy,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function AttendanceHistory()
    {
        return view('reports.attendance-history');
    }


    public function ExpensesReport(Request $request)
    {
        $filterBy = $request->input('filterBy');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $expenses = Expense::when($request->filterBy, function ($query) use ($filterBy, $startDate, $endDate) {
            if ($filterBy == 'weekly') {
                return $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($filterBy == 'monthly') {
                return $query->whereYear('date', Carbon::now()->year)->whereMonth('date', Carbon::now()->month);
            } elseif ($filterBy == 'daily') {
                return $query->whereDate('date', Carbon::today());
            } elseif ($filterBy == 'custom' && $startDate && $endDate) {
                return $query->whereBetween('date', [Carbon::parse($startDate), Carbon::parse($endDate)]);
            } else {
                return $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            }
        })->whereYear('date', Carbon::now()->year)
        ->where('club_id', Auth::user()->club_id)->get();

        return view('reports.expenses-report', [
            'expenses' => $expenses,
            'filterBy' => $filterBy,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }


    public function ProfitandLoss(Request $request)
    {
        $filterBy = $request->input('filterBy');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        if ($filterBy === 'weekly') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($filterBy === 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filterBy === 'yearly') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($filterBy === 'custom' && $startDate && $endDate) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('startDate'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('endDate'));
        } else {
            $startDate = Carbon::now()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        }
        
    
        $fees = Fees::whereBetween('date',[$startDate, $endDate])->sum('amount');
        $expenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $totalIncome = $fees;
        $totalExpense = $expenses;
    
        $netProfitLoss = $totalIncome - $totalExpense;
    
        return view('reports.profit-and-loss', compact('totalIncome', 'totalExpense', 'netProfitLoss', 'filterBy'));
    }
}