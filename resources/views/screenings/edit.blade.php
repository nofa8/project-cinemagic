@extends('layouts.main')

@section('header-title', 'Edit Screening')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Screening {{$screening->id}} of {{$screening->movie->title}}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click on "Save" button to store the information.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('screenings.update', ['screening', $screening->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mt-6 space-y-4">
                            <x-field.select name="movie_id" label="Movie" value="{{$screening->movie_id}}" :options="$movies" />


                            <x-field.input name="date" label="Date" :readonly="false" value="{{ $screening->date }}" />
                            <x-field.input name="start_time" label="Start Time" :readonly="false"
                                value="{{ $screening->start_time }}" />
                            <x-field.select name="theater_id" label="Theater" value="" :options="$theaters" />

                            
                        </div>
                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Save" class="uppercase" />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
