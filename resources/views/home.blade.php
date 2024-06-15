@extends('layouts.main')

@section('header-title', 'Introduction')

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <section class="py-12 px-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-700 dark:text-gray-200">
                <h2 class="text-2xl font-semibold leading-tight">CineMagic: Your Gateway to Unforgettable Movie Experiences</h2>
                <p class="mt-4 text-lg leading-loose">
                  CineMagic is your ultimate destination for an unparalleled movie-watching experience in theaters. Our platform is dedicated to bringing the magic of the big screen to life, providing movie enthusiasts with seamless access to the latest blockbusters and timeless classics in the best cinemas near you.
                </p>
                <ul class="list-disc space-y-2 mt-6 ml-6">
                  <li>Effortlessly browse showtimes</li>
                  <li>Reserve your favorite seats</li>
                  <li>Purchase tickets in advance</li>
                </ul>
                <p class="mt-4 text-lg leading-loose">
                  With CineMagic, you can ensure a hassle-free and enjoyable outing. Our commitment to delivering high-quality visuals and immersive soundscapes guarantees that every visit to the theater is a memorable one. Join the CineMagic community today and rediscover the joy of watching movies the way they were meant to be seen – on the big screen.
                </p>
                <a href="{{ route('movies.showcase') }}" class="inline-flex items-center px-4 py-2 mt-6 text-white bg-blue-600 rounded-full hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium">
                  Browse Movies Now
                  <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </section>
              
        </div>
    </div>
</main>
@endsection
