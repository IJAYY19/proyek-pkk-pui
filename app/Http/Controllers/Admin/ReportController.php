<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Helper: Build the base transaction query with optional date filters.
     */
    private function filteredQuery(Request $request)
    {
        $query = Transaction::with('user', 'details.product')
            ->where('status', 'completed')
            ->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return $query;
    }

    /**
     * Display the reports page (with date filter + pagination).
     */
    public function index(Request $request)
    {
        $transactions = $this->filteredQuery($request)->paginate(10)->withQueryString();

        return view('admin.reports.index', compact('transactions'));
    }

    /**
     * Activity logs page.
     */
    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        return view('admin.logs.index', compact('logs'));
    }
}
