@extends('layouts.main')

@section('header-title', 'List of Movies')

@section('main')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        @each('movies.shared.card', $movies, 'movie')
    </div>
@endsection
