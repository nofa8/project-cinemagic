<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Ticket;
use App\Models\Purchase;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(): View
    {
        
        $now = now()->subDays(30);
        $ticketsTheater = Ticket::join('purchases','purchases.id','=','tickets.purchase_id')
        ->join('seats', 'tickets.seat_id', '=', 'seats.id')
        ->join('theaters', 'seats.theater_id', '=', 'theaters.id')
        ->select('theaters.name as theater_name', DB::raw('count(*) as total_tickets'))
        ->whereBetween('purchases.date', [$now, now()])
        ->groupBy('theaters.name')
        ->get();
        $moviesGenre = Movie::join('genres', 'movies.genre_code', '=', 'genres.code')
        ->join('screenings', 'screenings.movie_id','=','movies.id')
        ->select('genres.name as genre_name', DB::raw('count(*) as total_movies'))
        ->whereBetween('screenings.date', [$now, now()])
        ->groupBy('genres.name')
        ->get();
        
        $totalTickets = Ticket::join('purchases','purchases.id','=','tickets.purchase_id')->whereBetween('purchases.date', [$now, now()])->count();
        $mostExpensivePurchase = Purchase::whereBetween('purchases.date', [$now, now()])->max('total_price');
        $totalRevenue = Purchase::whereBetween('purchases.date', [$now, now()])->sum('total_price');
        $averagePurchasePrice = Purchase::whereBetween('purchases.date', [$now, now()])->avg('total_price');
        
        return view('statistics.index', compact('ticketsTheater', 'moviesGenre'))
            ->with('totalTickets', $totalTickets)
            ->with('mostExpensivePurchase', $mostExpensivePurchase)
            ->with('totalRevenue', $totalRevenue)
            ->with('averagePurchasePrice', $averagePurchasePrice);
    }

    public function redirectioning(Request $request): View{

        if (!$request->has('day')){
            return redirect()->route('statistics.index')
            ->with('alert-type', 'danger')
            ->with('alert-msg',  "Statistic period needed.");
        }

        $now = now();
        if ($request->day == 'MONTH'){
            $now = $now->subDays(30);
        }elseif ($request->day == 'WEEK'){
            $now = $now->subDays(7);
        }elseif ($request->day == 'TODAY'){
            $now = $now->subDays(1);
        }

        $ticketsTheater = Ticket::join('purchases','purchases.id','=','tickets.purchase_id')
        ->join('seats', 'tickets.seat_id', '=', 'seats.id')
        ->join('theaters', 'seats.theater_id', '=', 'theaters.id')
        ->select('theaters.name as theater_name', DB::raw('count(*) as total_tickets'))
        ->whereBetween('purchases.date', [$now, now()])
        ->groupBy('theaters.name')
        ->get();
        $moviesGenre = Movie::join('genres', 'movies.genre_code', '=', 'genres.code')
        ->join('screenings', 'screenings.movie_id','=','movies.id')
        ->select('genres.name as genre_name', DB::raw('count(*) as total_movies'))
        ->whereBetween('screenings.date', [$now, now()])
        ->groupBy('genres.name')
        ->get();

        $totalTickets = Ticket::join('purchases','purchases.id','=','tickets.purchase_id')->whereBetween('purchases.date', [$now, now()])->count();
        $mostExpensivePurchase = Purchase::whereBetween('purchases.date', [$now, now()])->max('total_price');
        $totalRevenue = Purchase::whereBetween('purchases.date', [$now, now()])->sum('total_price');
        $averagePurchasePrice = Purchase::whereBetween('purchases.date', [$now, now()])->avg('total_price');

        return view('statistics.index', compact('ticketsTheater', 'moviesGenre'))
            ->with('totalTickets', $totalTickets)
            ->with('mostExpensivePurchase', $mostExpensivePurchase)
            ->with('totalRevenue', $totalRevenue)
            ->with('averagePurchasePrice', $averagePurchasePrice)
            ->with('option', $request->day);
    }

    public function exportToExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StatisticsExport, 'statistics.xlsx');
    }
}
