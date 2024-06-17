@extends('layouts.main')


@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('theaters.create') }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('theaters.edit', ['theater' => $theater]) }}"
                        text="Edit"
                        type="primary"/>
                    <form method="POST" action="{{ route('theaters.destroy', ['theater' => $theater]) }}">
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
                        <b>Theater</b> - {{ $theater->name }}
                    </h2>
                </header>
                <div class="mt-6 space-y-4">
                    @include('theaters.shared.fields', ['mode' => 'show'])
                </div>
                <div class=" px-4 py-2 my-2 overflow-x-auto" disabled>
                    <fieldset disabled>

                        <x-seats.table  :seats="$theater->seats" :tickets="new Illuminate\Database\Eloquent\Collection()" />
                    </fieldset >
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
