@extends('layouts.main')

@section('header-title', 'Seats for Screening: ' . $screening->movie->title)

@section('main')
<div class="container mx-auto px-4">
    <div class="flex flex-col space-y-6">
        <div class="shadow sm:rounded-lg p-4 sm:p-8 relative bg-fixed bg-center  bg-no-repeat"
        style="background-image:linear-gradient(rgba(65, 63, 63, 0.397), rgb(57, 57, 58)), url({{$screening->movie->imageFullUrl}})">
        
        {{-- class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg"> --}}
            <section class="px-3 py-6 justify-center my-2">
                <header>
                    <h2 class="text-2xl font-extrabold text-white">
                        Screening for "{{ $screening->movie->title }}"
                        <br>Theater: {{ $screening->theater->name}}
                        <br>Date: {{ $screening->date}}, {{$screening->start_time}}
                    </h2>
                </header>
                    <div class="py-6 justify-center my-4">
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
