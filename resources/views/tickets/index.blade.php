@extends('layouts.main')

@section('header-title', 'List of Tickets')

@section('main')
    <div class="flex justify-center">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <div class="font-base text-sm pr-6 mr-6 text-gray-700 dark:text-gray-300">
                <x-tickets.tab :tickets="$tickets" :showView="true"/>
            </div>
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
@endsection
