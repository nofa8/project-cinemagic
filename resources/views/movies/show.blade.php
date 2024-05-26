@extends('layouts.main')

@section('header-title', 'Movie "' . $movie->title . '"')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('movies.create', ['movie' => $movie]) }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="Edit"
                        type="primary"/>
                    <form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Movie "{{ $movie->title }}"
                    </h2>
                </header>
                @include('movies.shared.fields', ['mode' => 'show'])

                <h3 class="pt-16 pb-4 text-2xl font-medium text-gray-900 dark:text-gray-100">
                    Screenings
                </h3>
                <x-screenings.table :screenings="$movie->screenings"
                    :showView="true"
                    :showEdit="false"
                    :showDelete="false"
                    class="pt-4"
                    />

            </section>
        </div>
    </div>
</div>
@endsection
