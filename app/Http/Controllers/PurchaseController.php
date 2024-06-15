<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseFormRequest;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Seat; 
use App\Models\Ticket; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rule;

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

        $auth = Auth::check();
        if ($auth && empty(session()->get('cart'))){
            $cart = [];
        }else{
            $cart = ($auth) ? session()->get('cart', collect()) : json_decode(Cookie::get('cart'), true) ?? [];
        }

        //dd($cart);
        $customer = Customer::find(Auth::user()->id) ;
        

        

        $request->validate([
            'Total_pay' => 'required|numeric|between:0,99999999.99',
            'payment_type' => ['required', Rule::in(['VISA', 'PAYPAL', 'MBWAY'])],
            'payment_ref' => 'required|string|max:255',
        ]);


        if (!$auth){
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:customers',
                'nif' => 'sometimes|string|size:9', 
            ]);
            $customer = [
                'id'=>null,
                'name' => $request->name,
                'email' => $request->email,
                'nif' => $request?->nif,
            ];
        }else{
            $customer->payment_type = $request->payment_type;
            $customer->payment_ref = $request->payment_ref;
            $customer->save();
            $customer = $customer->user->toArray();
        }

        if ($customer == null){
            $customer = new Customer;
            $customer->id = Auth::user()->id;
            $customer->payment_type = $request->payment_type;
            $customer->payment_ref = $request->payment_ref;
            $customer->save();
            $customer = $customer->user->toArray();
        }
        
        $purchases = [
            'customer_name' => $customer['name'],
            'customer_email' => $customer['email'],
            'customer_id' => $customer['id'],
            'date' => now(),
            'total_price' => $request->get('Total_pay'),
            'payment_type' => $request->get('payment_type'),
            'payment_ref' => $request->get('payment_ref'),
        ];
        $purchase = Purchase::create($purchases); // Create a new purchase record
        $indivValue = $request->get('Total_pay')/count($cart);
        $tickets = [];
        foreach ($cart as $cartData) {
            
            //dd($customer, $cartData, $indivValue);
            $tickets[] = [
                'screening_id' => $cartData['screening_id'],
                'seat_id' => $cartData['seat_id'],
                'price' => $indivValue, 
                'purchase_id' => $purchase->id, 
                'status' => 'valid',
            ];
        }
        
        Ticket::insert($tickets); 

        if ($auth) {
            $request->session()->forget('cart');
        }else{
            Cookie::queue(Cookie::forget('cart'));
        }

        return redirect()->route('cart.show')->with('success', 'Purchase created successfully!');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('customer', 'tickets.seat'); // Eager load customer and ticket data with seat

        return view('purchases.show', compact('purchase'));
    }


}
