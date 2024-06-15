@extends('layouts.main')

@section('header-title', 'Welcome to CineMagic')

@section('main')
<main class="bg-gray-100 dark:bg-gray-800 min-h-screen">
    <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
        <div class="my-6 p-8 bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-lg text-gray-900 dark:text-gray-50">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 leading-tight mb-4">
                Welcome to CineMagic
            </h2>
            <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-6">
                Dive into the world of movies with CineMagic, your ultimate destination for the latest blockbusters, timeless classics, and everything in between.
            </p>
            <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                Join us for an unparalleled cinematic experience, where we bring the magic of the big screen to life. From exclusive premieres to special screenings, CineMagic is more than just a cinema—it's a community for movie lovers.
            </p>
        </div>
        <div class="my-6 p-8 bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-lg text-gray-900 dark:text-gray-50">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 leading-tight mb-4">
                About Us
            </h2>
            <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-6">
                CineMagic is recognized for its outstanding contribution to the film industry and education. Our state-of-the-art facilities and experienced staff ensure a premium viewing experience for all our guests.
            </p>
            <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                Whether you're a casual viewer or a film aficionado, CineMagic offers a range of screenings, events, and educational programs designed to entertain and inspire.
            </p>
        </div>
        
    </div>
</main>
@endsection
