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
use Illuminate\Support\Carbon;

class ScreeningController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        //$this->authorizeResource(Screening::class);
    }


    public function index(): View
    {
        $allScreens = Screening::where('date', '>=', now()->startOfDay())
            ->where('date', '<=', now()->addDays(14)->endOfDay())
            ->where(function ($query) {
                $query->where('date', '>', now()->startOfDay())
                    ->orWhere(function ($query) {
                        $query->where('date', '=', now()->startOfDay())
                            ->where('start_time', '>', now()->format('H:i:s'));
                    });
            })
            ->orderBy('date', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('screenings.index')->with('screenings', $allScreens);
    }
    public function show(Screening $screening): View
    {
        return view('screenings.show')->with('screening', $screening);
    }

    public function management(): View
    {
        $allScreens = Screening::
            orderBy('date', 'desc')
            ->paginate(21)
            ->withQueryString();
        return view('screenings.management')->with('screenings',$allScreens);
    }
    
    public function create(Request $request): View
    {
        $newScreening = new Screening();
        

        return view('screenings.create')->with('screening', $newScreening);
    }

    public function store(ScreeningFormRequest $request): RedirectResponse
    {
        
        $validatedData = $request->validated();
        $newScreening = DB::transaction(function () use ($validatedData) {
            $newScreening = new Screening();
            $newScreening->movie_id = $validatedData['movie_id'];
            $newScreening->theater_id = $validatedData['theater_id'];
            $newScreening->date = $validatedData['date'];
            $newScreening->start_time = $validatedData['start_time'];
            $newScreening->save();
            return $newScreening;
        });


        $url = route('screenings.management');
        $htmlMessage = "Screening <a href='$url'><u>{$newScreening->id}</u></a> ({$newScreening->date}) has been created successfully!";
        $newScreening->save();
        return redirect()->route('screenings.management')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Screening $screening): View
    {
        $movies = Movie::orderBy('title')->pluck('title', 'id')->toArray();
        $theaters = Theater::pluck('name', 'id')->toArray();

        return view('screenings.edit')->with('screening', $screening)->with('movies', $movies)->with('theaters', $theaters);
    }

    public function update(ScreeningFormRequest $request, Screening $screening): RedirectResponse
    {
        
        $validatedData = $request->validated();


        $totalTicketsScreening = $screening->tickets()->count();

       
        $url = route('screenings.show', ['screening' => $screening]);
        if ($totalTicketsScreening == 0) {
            $screening = DB::transaction(function () use ($validatedData, $screening) {
                $screening->movie_id = $validatedData['movie_id'];
                $screening->theater_id = $validatedData['theater_id'];
                $screening->date = $validatedData['date'];
                $screening->start_time = $validatedData['start_time'];
                
                $screening->save();
                
                return $screening;
            });
            $htmlMessage = "Screening <a href='$url'><u>{$screening->id}</u></a> updated with success.";
            $alertType = 'success';
        } else {
            $alertType = 'warning';
            $justification = match (true) {
                $totalTicketsScreening <= 0 => "",
                $totalTicketsScreening == 1 => "there is 1 ticket for this screening",
                $totalTicketsScreening > 1 => "there are {$totalTicketsScreening} tickets for this screening",
            };
            $htmlMessage = "Screening <a href='$url'><u>{$screening->id}</u></a> cannot be deleted because $justification.";
        }


        
        
        
        return redirect()->route('screenings.show', ['screening' =>$screening])
            ->with('alert-type', $alertType)
            ->with('alert-msg', $htmlMessage);
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
                $alertMsg = "Screening {$screening->id}, {$screening->date} {$screening->start_time}, {$screening->movie->title}, {$screening->theater->name} has been deleted successfully!";
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
