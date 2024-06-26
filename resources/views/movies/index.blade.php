@extends('layouts.main')

@section('header-title', 'List of Movies')

@section('main')
    <div class="flex justify-center">
        @if(($tr ?? '' ) === "trash" )
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <x-movies.filter-card :filterAction="route('movies.deleted')" :resetUrl="route('movies.deleted')" :genres="$movies->pluck('name', 'genre')->toArray()" :genre="old('name', $filterByGenre)" :tilte="old('title', $filterByName)"
                class="mb-6" />
            
            <div class="font-base text-sm pr-6 mr-6 text-gray-700 dark:text-gray-300">
                <x-movies.table :movies="$movies" :trash="true" :showView="true"  :showDelete="true" />
            </div>
            
            
            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
        @else
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <x-movies.filter-card :filterAction="route('movies.index')" :resetUrl="route('movies.index')" :genres="$movies->pluck('name', 'genre')->toArray()" :genre="old('name', $filterByGenre)" :tilte="old('title', $filterByName)"
                class="mb-6" />
            @can('create', App\Models\Movie::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button href="{{ route('movies.create') }}" text="Create a new movie" type="success" />
                </div>
            @endcan
            
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-movies.table :movies="$movies" :showView="true" :showEdit="true" :showDelete="true" />
            </div>
            
            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>


        @endif
    </div>
@endsection
