<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Seat;
use App\Models\Theater;
use Illuminate\Http\RedirectResponse;
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


    public function show(Screening $screenings): View
    {
        $seats = $screenings->theater->seats;
        $tickets = $screenings->tickets->values();
        return view('seats.show')
            ->with('screening', $screenings)
            ->with('seats', $seats)
            ->with('tickets', $tickets);
    }


    public function destroyUpdate(Request $request)
    {
        $success = [];
        $failure = [];
        $seat = $request->get('seats');
        
        foreach ($seat as $id) {
            $the_seat = Seat::find($id);
            $val = $the_seat?->tickets()->whereHas('screening', function ($query) {
                $query->where('date', '>', now());
            })->count();
            if ($val > 0) {
                $failure[] = $id;
                continue;
            }
            $the_seat->delete();
            $success[] = $id;
        }
        $successMessage = "";
        $errorMessage = "";

        if (count($success) > 0) {
            $successMessage = "Seats(s): " . implode(', ', $success) . " successfully deleted!";
        }

        if (count($failure) > 0) {
            $errorMessage = "Seats(s): " . implode(', ', $failure) . " not deleted, have tickets for future screenings!";
        }

        $alertType = (count($failure) > 0) ? 'warning' : 'success';
        $htmlMessage = $successMessage . $errorMessage; // Combine success and error messages

        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    }

    public function destroy(Seat $seat)
    {
        $val = $seat->tickets->screening->where('date', '>', now())->count();
        if ($val > 0) {
            return redirect()->back()
                ->with('error', 'Seat has ' . $val . ' tickets for future screenings');
        }
        $seat->delete();

        return redirect()->back()
            ->with('success', 'Seat deleted successfully.');
    }

    public function store(Request $request, Theater $theater): RedirectResponse
    {
        $request->validate([
            'row' => 'required|string|max:1',
            'seat_number' => 'required|integer|min:1|max:50',
        ]);

        $seatData = [
            'theater_id' => $theater->id,
            'row' => $request->get('row'),
            'seat_number' => $request->get('seat_number'),
        ];

        $seat = Seat::create($seatData);

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Seats created');
    }

}
