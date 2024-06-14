@extends('layouts.main')

@section('header-title', 'List of Movies')

@section('main')
    <x-movies.filter-card :filterAction="route('movies.showcase')" :resetUrl="route('movies.showcase')" :genres="$movies->pluck('name', 'genre')->toArray()"
        :genre="old('name', $filterByGenre)"
        :tilte="old('title', $filterByName)" class="mb-6" />
    

    <div class="grid grid-cols-1 gap-5">
        @each('movies.shared.card', $movies, 'movie')
    </div>
    <div class="mt-4">
        {{ $movies->links() }}
    </div>

@endsection
