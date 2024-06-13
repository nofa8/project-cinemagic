<!-- resources/views/tickets/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <div class="max-w-xl mx-auto bg-white p-5 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-5">Ticket Details</h1>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket ID: {{ $ticket->id }}</h2>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket Name: {{ $ticket->name }}</h2>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket Price: ${{ $ticket->price }}</h2>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Event Date: {{ $ticket->event_date->format('F j, Y') }}</h2>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route('tickets.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Tickets</a>
            <a href="{{ route('cart.add', ['ticket' => $ticket->id]) }}" class="bg-green-500 text-white px-4 py-2 rounded">Add to Cart</a>
        </div>
    </div>
</div>
@endsection
