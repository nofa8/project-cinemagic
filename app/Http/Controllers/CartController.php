<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketFormRequest;
use App\Models\Screening;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function show(): View 
    { 
        if (Auth::check() && empty(session()->get('cart'))){
            $cart = [];
        }else{
            $cart = (Auth::check()) ? session()->get('cart', collect()) : json_decode(Cookie::get('cart'), true) ?? [];

        }
        $much = count($cart);
        return view('cart.show', compact('cart'))->with('many',$much); 
    } 

    public function addToCart(Request $request, Screening $screening) // Assuming you want a single screening object
    {
        $screeningId = $screening->id;
        $seatIds = $request->get('seats');
        // Validate seat IDs (optional)
        // You can add validation here to ensure valid seat IDs are provided
        if (Auth::check() && empty(session()->get('cart'))){
            $cart = [];
        }else{
            $cart = (Auth::check()) ? session()->get('cart', collect()) : json_decode(Cookie::get('cart'), true) ?? [];

        }

        $addedSeats = []; 
        $failedSeats = [];

        foreach ($seatIds as $seatId) {
            $cartItem = null;
            
            $cartItem = array_filter($cart, function ($item) use ($screeningId, $seatId) {
                return $item['screening_id'] == $screeningId && $item['seat_id'] == $seatId;
            });
            $cartItem = reset($cartItem) ?? null;
            
            if ($cartItem) {
                $failedSeats[] = $seatId; 
                continue; 
            }
            $cartItem = [
                'screening_id' => $screeningId,
                'seat_id' => $seatId,
            ];

            $cart[] = $cartItem;
            session()->put('cart', $cart);
            $addedSeats[] = $seatId;
        }

        $successMessage = "";
        $errorMessage = "";

        if (count($addedSeats) > 0) {
            $successMessage = "Screening with seat(s): " . implode(', ', $addedSeats) . " added to the cart!";
        }

        if (count($failedSeats) > 0) {
            $errorMessage = "Screening with seat(s): " . implode(', ', $failedSeats) . " already exist(s) in the cart!";
        }

        $alertType = (count($failedSeats) > 0) ? 'warning' : 'success';
        $htmlMessage = $successMessage . $errorMessage; // Combine success and error messages

        if (!Auth::check()) {
            $cookie = Cookie::make('cart', json_encode($cart), time() + 3600 * 24); // Expires in 24 hours
            Cookie::queue($cookie);
        }
        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    }


    public function destroy(Request $request): RedirectResponse
    {

        if (Auth::check() && empty(session()->get('cart'))){
            return back()
            ->with('alert-type', 'error')
            ->with('alert-msg', 'Shopping Cart didn\'t need any cleaning');
        }else{

            if (Auth::check()) {
                $request->session()->forget('cart');
            }else{
                Cookie::queue(Cookie::forget('cart'));
            }

        }
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared');
    }
}
