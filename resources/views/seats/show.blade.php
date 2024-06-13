@extends('layouts.main')

@section('header-title', 'Seats for Screening: ' . $screening->movie->title)

@section('main')
<div class="container mx-auto px-4">
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Screening for "{{ $screening->movie->title }}"
                    </h2>
                </header>
                    <h3 class="pt-16 pb-4 text-2xl font-medium text-gray-900 dark:text-gray-100">
                        Seats
                    </h3>
                    <div>
                        <form method="POST" action="{{ route('cart.add', ['screening' => $screening]) }}">
                            @csrf
                            <x-seats.table :seats="$seats" :tickets="$tickets" />
                            <x-button class=" gap-4 mt-4" element="submit" text="Add to cart" type="dark"/>
                        </form>
                    </div>
            </section>
        </div>
    </div>
</div>
@endsection
