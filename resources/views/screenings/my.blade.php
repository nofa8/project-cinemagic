@extends('layouts.main')

@section('header-title', 'My Disciplines')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
            <x-disciplines.table :disciplines="$disciplines"
                :showCourse="true"
                :showView="true"
                :showEdit="true"
                :showDelete="true"
                :showAddToCart="true"
                />
            </div>
        </div>
    </div>
@endsection
