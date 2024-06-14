<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseFormRequest;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Seat; 
use App\Models\Ticket; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

class PurchaseController extends Controller
{
    public function index()
    {
        // Implement logic to retrieve all purchases or paginate results
        $purchases = Purchase::with('customer')->get(); // Eager load customer data

        return view('purchases.index', compact('purchases'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer|exists:customers,id', // Validate customer ID exists
            'payment_type' => 'required|string|in:VISA,PAYPAL,MBWAY', // Validate payment type
            'total_price' => 'required|numeric|min:0', // Validate total price
            // Add validation for other purchase data as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $purchase = Purchase::create($request->validated());

        // Logic to create associated tickets based on purchase data (replace with your logic)
        foreach ($request->get('seats', []) as $seatData) {
            $ticket = new Ticket;
            $ticket->purchase_id = $purchase->id;
            $ticket->seat_id = $seatData['id']; // Assuming seat ID is provided in request data
            $ticket->code = uniqid(); // Generate unique ticket code
            $ticket->save();
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully!');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('customer', 'tickets.seat'); // Eager load customer and ticket data with seat

        return view('purchases.show', compact('purchase'));
    }


}
