<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Ticket;
use App\Models\Purchase;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(): View
    {
        $totalTickets = Ticket::count();
        $mostExpensivePurchase = Purchase::max('total_price');
        $totalRevenue = Purchase::sum('total_price');
        $averagePurchasePrice = Purchase::avg('total_price');

        return view('statistics.index')
            ->with('totalTickets', $totalTickets)
            ->with('mostExpensivePurchase', $mostExpensivePurchase)
            ->with('totalRevenue', $totalRevenue)
            ->with('averagePurchasePrice', $averagePurchasePrice);
    }

    public function exportToExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StatisticsExport, 'statistics.xlsx');
    }
}
