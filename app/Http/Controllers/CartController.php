<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
class CartController extends Controller
{
    
    public function addToCart(Request $request, Ticket $ticket): RedirectResponse
    {
        $cart = session('cart', null);

        if (!$cart) {
            $cart = collect([$ticket]);
            $request->session()->put('cart', $cart);
        } else {
            if ($cart->contains('id', $ticket->id)) {
                $alertType = 'warning';
                $url = route('tickets.show', ['ticket' => $ticket]);
                $htmlMessage = "Ticket <a href='$url'>#{$ticket->id}</a>
                                <strong>\"{$ticket->name}\"</strong> was not added to the cart because it is already there!";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            } else {
                $cart->push($ticket);
            }
        }

        $alertType = 'success';
        $url = route('tickets.show', ['ticket' => $ticket]);
        $htmlMessage = "Ticket <a href='$url'>#{$ticket->id}</a>
                        <strong>\"{$ticket->name}\"</strong> was added to the cart.";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

}
