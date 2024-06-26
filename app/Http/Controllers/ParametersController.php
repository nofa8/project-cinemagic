<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ParametersController extends Controller
{
    public function index(Request $request): View
    {
        $configuration = \App\Models\Configuration::firstOrFail();
        return view('parameters.index', compact('configuration'));
    }

    public function updateTicketPrice(Request $request): RedirectResponse
    {
        try{
            $request->validate([
                'ticketPrice' => 'required|numeric|min:0',
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('alert-type', 'danger')
                ->with('alert-msg',  "The minimum value for the ticket price is 0!");

        }
        

        $configuration = \App\Models\Configuration::firstOrFail();
        $configuration->ticket_price = $request->ticketPrice;
        $configuration->save();

        return redirect()->route('parameters.index')
            ->with('success', 'Ticket price updated successfully.');
    }

    public function updateDiscount(Request $request): RedirectResponse
    {
        

        try{
            $request->validate([
                'ticketDiscount' => 'required|numeric|min:0',
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('alert-type', 'danger')
                ->with('alert-msg',  "The minimum value for the ticket discount is 0!");
        }

        $configuration = \App\Models\Configuration::firstOrFail();
        $configuration->registered_customer_ticket_discount = $request->ticketDiscount;
        $configuration->save();

        return redirect()->route('parameters.index')->with('success', 'Ticket discount updated successfully.');
    }

}
