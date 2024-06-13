<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Collection;
class SeatController extends Controller
{
    public function create(): View
    {
        // You may need other data here depending on your application requirements
        return view('seats.create');
    }

    public function index(): View
    {
        //
        return view('seats.index');
    }

   
    public function show(Screening $screenings): View{
        $seats = $screenings->theater->seats;
        $tickets = $screenings->tickets;
        return view('seats.show')
            ->with('screening',$screenings)
            ->with('seats',$seats)
            ->with('tickets', $tickets);    
    }
    

    public function destroy(Seat $seat)
    {
        $seat->delete();

        return redirect()->route('seats.index')
                         ->with('success', 'Seat deleted successfully.');
    }

}
