<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\TicketFormRequest;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    use AuthorizesRequests;


    public function __construct()
    {
        $this->authorizeResource(Ticket::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterByScreening = $request->query('screening_id');
        $filterBySeat = $request->query('seat_id');
        $ticketQuery = Ticket::query();
        if ($filterByScreening !== null) {
            $ticketQuery->where('screening_id', $filterByScreening);
        }
        if ($filterBySeat !== null) {
            $ticketQuery->where('seat_id', $filterBySeat);
        }

        $tickets = $ticketQuery
            ->with('screening')
            ->orderBy('seat_id')
            ->orderBy('price')
            ->orderBy('status')
            ->paginate(20)
            ->withQueryString();
        return view(
            'tickets.index',
            compact('tickets', 'filterByScreening', 'filterBySeat')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tick = new Ticket();
        return view('tickets.create')->with('ticket', $tick);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketFormRequest $request)
    {
        $NewTicket = Ticket::create($request->validated());
        $url = route('tickets.show', ['ticket' => $NewTicket]);
        $htmlMessage = "Ticket <a href='$url'><u>{$NewTicket->id}</u></a> ({$NewTicket->price}) has been created successfully!";
        return redirect()->route('tickets.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): View
    {
        return view('tickets.show')
            ->with('ticket', $ticket);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit')
            ->with('ticket', $ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketFormRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update($request->validated());
        $url = route('tickets.show', ['ticket' => $ticket]);
        $htmlMessage = "Ticket <a href='$url'><u>{$ticket->id}</u></a> ({$ticket->price}) has been updated successfully!";
        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        try {
            $url = route('tickets.show', ['ticket' => $ticket]);
            $totalTickets = $ticket->purchases()->customers()->count();
            // $totalTickets = DB::table('purchases')
            // ->join('customers', 'purchases.customer_id', '=', 'customers.id')
            // ->where('purchases.ticket_id', $ticket->id)
            // ->distinct('customers.id')
            // ->count('customers.id');
            if ($totalTickets == 0 ) {
                $ticket->delete();
                $alertType = 'success';
                $alertMsg = "ticket {$ticket->name} ({$ticket->abbreviation}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $customersStr = match (true) {
                    $totalTickets <= 0 => "",
                    $totalTickets == 1 => "ticket has been bought",
                };
                $justification = $customersStr 
                    ? "$customersStr"
                    : "$customersStr";
                $alertMsg = "ticket <a href='$url'><u>{$ticket->id}</u></a> ({$ticket->price}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the ticket
                            <a href='$url'><u>{$ticket->id}</u></a> ({$ticket->price})
                            because there was an error with the operation!";
        }
        return redirect()->route('tickets.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
