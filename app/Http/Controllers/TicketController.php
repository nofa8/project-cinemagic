<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Screening;
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
        //$this->authorizeResource(Ticket::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $filterByScreening = $request->query('screening_id');
        // $filterBySeat = $request->query('seat_id');
        $userId = auth()->id(); // Obter o ID do usuário autenticado

        // Iniciar a consulta do Ticket com um join na tabela 'purchases'
        $ticketQuery = Ticket::query()
            ->join('purchases', 'tickets.purchase_id', '=', 'purchases.id')
            ->where('purchases.customer_id', $userId); // Filtrar tickets pelo customer_id associado ao usuário autenticado
        // if ($filterByScreening !== null) {
        //     $ticketQuery->where('tickets.screening_id', $filterByScreening);
        // }
        // if ($filterBySeat !== null) {
        //     $ticketQuery->where('tickets.seat_id', $filterBySeat);
        // }

        $tickets = $ticketQuery
            ->with('screening')
            ->orderBy('purchases.date', 'desc')
            ->orderBy('tickets.seat_id','desc')
            ->paginate(20)
            ->withQueryString();

        // return view('tickets.index', compact('filterByScreening', 'filterBySeat'))
        //     ->with('tickets', $tickets);
        return view('tickets.index')->with('tickets', $tickets);
    }

    public function everyIndex()
    {

       
        $tickets =Ticket::with('screening')->with('screening.movie')->with('seat')
            ->join('purchases', 'tickets.purchase_id', '=', 'purchases.id')
            ->orderBy('purchases.date','desc')
            ->orderBy('screening_id','desc')
            ->orderBy('seat_id', 'desc')
            ->paginate(20)
            ->withQueryString();

        // return view('tickets.index', compact('filterByScreening', 'filterBySeat'))
        //     ->with('tickets', $tickets);
        return view('tickets.index')->with('tickets', $tickets);
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

    public function show(Ticket $ticket)
    {
        return view('tickets.show', ['ticket' => $ticket]);
    }
    public function showTicket(Ticket $ticket)
    {
        return view('tickets.ticket', ['ticket' => $ticket]);
    }

    public function save(Request $request)
    {
        $ticket = $request->validated();

        return view('tickets.show')->with($ticket);
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
            if ($totalTickets == 0) {
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

    public function verify(Request $request, Screening $screening)
    {
        $isValid = false;
        $ticket = null;
        if ($request->filled('ticket_id')) {
            $ticketCount = Ticket::where('id', $request->ticket_id)
                ->where('screening_id', $screening->id)
                ->where('status', 'valid')
                ->count();


            if ($ticketCount > 0) {
                $ticket = Ticket::where('id', $request->ticket_id)
                    ->where('screening_id', $screening->id)
                    ->where('status', 'valid')
                    ->first();
                $isValid = true;
            }

        }
        if ($isValid && $ticket) {
            return redirect()->route('tickets.show', ['ticket' => $ticket->id])
                ->with('alert-type', 'success')
                ->with('alert-msg', 'Ticket is Valid.');
        } else {
            return redirect()->back()
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Ticket is Invalid.');
        }
    }
    public function validate(Request $request, Ticket $ticket)
    {
        
        $screening = $ticket->screening;
        $ticket->status = 'invalid';
        $ticketUpdated = $ticket->update($ticket->toArray());

        if($request->val == 0){
            return redirect()->route('screenings.show', ['screening' => $screening])
                ->with('alert-type', 'success')
                ->with('alert-msg', 'Ticket has been invalidated!');
        }

        $url = route('tickets.show', ['ticket' => $ticket]);
        $htmlMessage = "Ticket <a href='$url'><u>{$ticket->id}</u></a> ({$ticket->price}) has been validated successfully!";
        return redirect()->route('screenings.show', ['screening' => $screening])
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);

    }
}



