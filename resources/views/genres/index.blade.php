@extends('layouts.main')

@section('header-title', 'List of Genres')

@section('main')
@php
$trash = $tr ?? '' === "trash";
@endphp
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            @if( !$trash )
            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('genres.create') }}"
                    text="Create a new genre"
                    type="success"/>
            </div>
            @endif
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-genres.table :trash="$trash" :genres="$genres" :showView="true" :showEdit="true" :showDelete="true"
                    />
            </div>
            <div class="mt-4">
                {{ $genres->links() }}
            </div>
        </div>
    </div>
@endsection
