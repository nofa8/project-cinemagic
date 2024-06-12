@extends('layouts.main')

@section('header-title', 'List of Disciplines')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-disciplines.filter-card
                :filterAction="route('disciplines.index')"
                :resetUrl="route('disciplines.index')"
                :courses="$courses->pluck('fullName', 'abbreviation')->toArray()"
                :course="old('course', $filterByCourse)"
                :year="old('year', $filterByYear)"
                :semester="old('semester', $filterBySemester)"
                :teacher="old('teacher', $filterByTeacher)"
                class="mb-6"
                />
            @can('create', App\Models\Discipline::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('disciplines.create') }}"
                        text="Create a new discipline"
                        type="success"/>
                </div>
            @endcan
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
            <x-disciplines.table :disciplines="$disciplines"
                :showCourse="true"
                :showView="true"
                :showEdit="true"
                :showDelete="true"
                :showAddToCart="true"
                />
            </div>
            <div class="mt-4">
                {{ $disciplines->links() }}
            </div>
        </div>
    </div>
@endsection
