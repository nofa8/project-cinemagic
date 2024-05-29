@extends('layouts.main')

@section('header-title', $movie->title)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Screenings of "{{ $movie->title }}"
                    </h2>
                </header>
                <x-courses.screenings :screenings="$movie->screenings"
                    :showView="true"
                    class="pt-4"
                    />
            </section>
        </div>
    </div>
</div>
@endsection
