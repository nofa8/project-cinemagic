@extends('layouts.main')

@section('header-title', 'Introduction')

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Welcome to CineMagic
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                The Master's course in Computer Engineering - Mobile Computing has been recognized by
                ENAEE (European Network for
                Accreditation of Engineering Education) through the award of the EUR-ACE® Quality Mark.
                The distinction places the
                quality of teaching in this course at the Polytechnic of Leiria at the level of the best
                European universities and
                polytechnics, and confirms the international dimension of the School's diplomas,
                encouraging greater acceptance of
                engineers graduating from the Polytechnic of Leiria throughout Europe.
            </p>
        </div>
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Organization
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                The organization of the Department of Computer Engineering is defined by the ESTG
                statutes as follows:
            <ul class="list-disc ms-12">
                <li class="py-1 font-medium text-gray-700 dark:text-gray-300">Coordinator;</li>
                <li class="py-1 font-medium text-gray-700 dark:text-gray-300">Department Council;</li>
                <li class="py-1 font-medium text-gray-700 dark:text-gray-300">Plenary.</li>
            </ul>
            </p>
        </div>
    </div>
</main>
@endsection
