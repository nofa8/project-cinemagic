@extends('layouts.main')

@section('header-title', 'List of Screenings')

@section('main')

    <div class="grid grid-cols-1 gap-5">
        @each('screenings.shared.cards', $screenings, 'screening')
    </div>
    <div class="mt-4">
        {{ $screenings->links() }}
    </div>
    
@endsection
