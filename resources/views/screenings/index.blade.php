@extends('layouts.main')

@section('header-title', 'List of Screenings')

@section('main')
    
    @can('create', App\Models\Movie::class)
        <div class="flex items-center gap-4 mb-4">
            <x-button href="{{ route('screenings.create') }}" text="Create a new Screening" type="success" />
        </div>
    @endcan

    <div class="grid grid-cols-1 gap-5">
        @each('screenings.shared.cards', $screenings, 'screening')
    </div>
    <div class="mt-4">
        {{ $screenings->links() }}
    </div>
    
@endsection
