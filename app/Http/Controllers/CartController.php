<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketFormRequest;
use App\Models\Screening;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{

    public function addToCart(Request $request, Screening $screening) // Assuming you want a single screening object
    {
        $screeningId = $screening->id;
        $seatIds = $request->get('seats');

        // Validate seat IDs (optional)
        // You can add validation here to ensure valid seat IDs are provided

        $cart = session('cart', collect([]));

        $addedSeats = []; // Array to store successfully added seat IDs
        $failedSeats = []; // Array to store failed seat IDs (optional for error messages)

        foreach ($seatIds as $seatId) {
            // Check if screening and seat combination already exists in the cart
            $cartItem = $cart->where(function ($item) use ($screeningId, $seatId) {
                return $item['screening_id'] == $screeningId && $item['seat_id'] == $seatId;
            })->first();

            if ($cartItem) {
                $failedSeats[] = $seatId; // Add failed seat ID (optional)
                continue; // Skip to the next seat ID
            }

            // Create a new cart item with screening and seat information
            $cartItem = [
                'screening_id' => $screeningId,
                'seat_id' => $seatId,
                // You can add additional information like screening details or seat price here
            ];

            $cart[] = $cartItem;
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

        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    }
}
