<!-- resources/views/tickets/show.blade.php -->

@extends('layouts.main')

@section('main')


@include('tickets.shared.fields');

<form method="post" action="{{ route('tickets.validate', ['ticket' => $ticket])  }}" class="mt-6 space-y-6">
    @csrf
    <div class="flex items-center gap-4">
        <x-primary-button name="val" value=1> Validade Ticket</x-primary-button>
    </div>
</form>
<form method="post" action="{{ route('tickets.validate', ['ticket' => $ticket])  }}" class="mt-6 space-y-6">
    @csrf
    <div class="flex items-center gap-4">
        <x-danger-button name="val" value=0> Invalidade Ticket</x-primary-button>
    </div>
</form>

@endsection
