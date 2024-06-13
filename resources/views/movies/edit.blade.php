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
                        href="{{ route('movies.show', ['movie' => $movie]) }}"
                        text="View"
                        type="info"/>
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
                        Edit movie "{{ $movie->title }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('movies.update', ['movie' => $movie]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('movies.shared.fields', ['mode' => 'edit'])
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save" class="uppercase"
                        />
                        <x-button element="a" type="light" text="Reset" class="uppercase ms-4"
                                    href="{{ url()->full() }}"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<form method="POST" class="hidden" action="{{ route('movies.image.destroy', ['movie' => $movie]) }}" id="form_to_delete_image">
    @csrf
    @method('DELETE')
</form>
@endsection

