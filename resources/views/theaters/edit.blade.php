@extends('layouts.main')

@section('header-title', 'Theater "' . $theater->name . '"')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('theaters.create', ['theater' => $theater]) }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('theaters.show', ['theater' => $theater]) }}"
                        text="View"
                        type="info"/>
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
                        Edit theater "{{ $theater->name }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('theaters.update', ['theater' => $theater]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('theaters.shared.fields', ['mode' => 'edit'])
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save" class="uppercase"
                        />
                        <x-button element="a" type="light" text="Reset" class="uppercase ms-4"
                                    href="{{ url()->full() }}"/>
                    </div>
                </form>
            </section>

            <form method="POST" action="{{ route('seats.destroyAll', ["theater" => $theater]) }}">
                @csrf
                @method('DELETE')
                <div class=" px-4 py-2 my-2">
                    <x-seats.table  :seats="$theater->seats"  />
                </div>
                <x-button element="submit" type="dark" text="Update" class="uppercase"/>
            </form>
        </div>
    </div>
</div>
<form method="POST" class="hidden" action="{{ route('theaters.image.destroy', ['theater' => $theater]) }}" id="form_to_delete_image">
    @csrf
    @method('DELETE')
</form>
@endsection

