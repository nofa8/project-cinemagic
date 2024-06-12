<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\ScreeningFormRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Theater;
class ScreeningController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        //$this->authorizeResource(Screening::class);
    }


    public function index(): View
    {
        $allScreens = Screening::orderBy('movie_id')->orderBy('theater_id')->paginate(20)->withQueryString();

        return view('screenings.index')->with('allScreens', $allScreens);
    }
    public function show(Screening $screening): View
    {
        return view('screenings.show')->with('screening', $screening);
    }

    public function showCase(): View
    {
        return view('screenings.showcase');
    }

    public function create(): View
    {
        $newScreening = new Screening();
        return view('screenings.create')->with('screening', $newScreening);
    }

    public function store(ScreeningFormRequest $request): RedirectResponse
    {
        $newScreening = Screening::create($request->validated());

        $url = route('screenings.show', ['screening' => $newScreening]);
        $htmlMessage = "Screening <a href='$url'><u>{$newScreening->id}</u></a> ({$newScreening->date}) has been created successfully!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Screening $screening): View
    {
        $movies = Movie::orderBy('title')->pluck('title', 'id')->toArray();
        $theaters = Theater::pluck('name', 'id')->toArray(); 

        return view('screenings.edit')->with('movies', $movies)->with('theaters', $theaters);
    }

    public function update(ScreeningFormRequest $request, Screening $screening): RedirectResponse
    {
        $screening->update($request->validated());

        $url = route('screenings.show', ['screening' => $screening]);
        $htmlMessage = "Screening <a href='$url'><u>{$screening->id}</u></a> ({$screening->date}) has been updated successfully!";
        return redirect()->route('screening.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    public function showSeats(Screening $screening): View
    {
        $screening->load('tickets');
        
        return view('screenings.seats')->with('screening', $screening);
    }

    public function destroy(Screening $screening): RedirectResponse
    {
        try {
            $url = route('screenings.show', ['screening' => $screening]);

            $totalTicketsScreening = $screening->tickets()->count();

            if ($totalTicketsScreening == 0) {
                DB::transaction(function () use ($screening) {
                    $screening->delete();
                });
                $alertType = 'success';
                $alertMsg = "Screening {$screening->id}, {$screening->date} {$screening->movies()->pluck('name')} {$screening->theater_id} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalTicketsScreening <= 0 => "",
                    $totalTicketsScreening == 1 => "there is 1 ticket for this screening",
                    $totalTicketsScreening > 1 => "there are {$totalTicketsScreening} tickets for this screening",
                };
                $alertMsg = "Screening <a href='$url'><u>{$screening->id}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the screening
                            <a href='$url'><u>{$screening->id}</u></a>
                            because there was an error with the operation!";
        }
        return redirect()->route('screenings.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
