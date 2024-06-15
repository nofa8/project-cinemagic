@extends('layouts.main')

@section('header-title', 'List of Screenings')

@section('main')
    <div class="flex justify-center">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            
                <div class="flex items-center gap-4 mb-4">
                    <x-button href="{{ route('screenings.create') }}" text="Create a new screening" type="success" />
                </div>
            
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($screenings as $screening)
                        <div class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
                            <!-- Poster on the left -->
                            <a class="h-50 w-48 flex-shrink-0" href="{{ route('screenings.show', ['screening' => $screening]) }}">
                                <img class="h-full w-full object-cover pe-4" src="{{ $screening->movie->imageFullUrl }}">
                            </a>
                            
                            <!-- Content on the right -->
                            <div class="flex flex-col justify-center w-full">
                                <!-- Title -->
                                <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2" href="{{ route('screenings.show', ['screening' => $screening]) }}">
                                    {{ $screening->movie->title }}
                                </a>
                                
                                <!-- Movie Details -->
                                <div class="flex flex-col justify-center w-full">
                                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $screening->movie->year }}
                                    </div>
                                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                                        {{ $screening->movie->genreRef->name }}
                                    </div>
                                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                                        {{ $screening->date }}
                                    </div>
                                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                                        {{ $screening->start_time }}
                                    </div>
                                </div>
                                
                                <!-- Buttons -->
                                <div class="flex space-x-2 mt-4">
                                    <x-table.icon-show class="ps-3 px-0.5" href="{{ route('screenings.show', ['screening' => $screening]) }}" />
                                    <x-table.icon-edit class="px-0.5" href="{{ route('screenings.edit', ['screening' => $screening]) }}" />
                                    <x-table.icon-delete class="px-0.5" action="{{ route('screenings.destroy', ['screening' => $screening]) }}" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mt-4">
                {{ $screenings->links() }}
            </div>
        </div>
    </div>
@endsection
