<!-- resources/views/movies/shared/card.blade.php -->

<div class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
    <!-- Poster on the left -->
    <a class="h-48 w-48 flex-shrink-0" href="{{ route('movies.show', ['movie' => $movie]) }}">
        <img class="h-full w-full object-cover rounded-sm"
            src="{{ $movie->getPhotoFullUrlAttribute() }}">
    </a>
    
    <!-- Content on the right -->
    <div class="flex flex-col justify-center w-full">
        <!-- Title -->
        <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2" href="{{ route('movies.show', ['movie' => $movie]) }}">
            {{ $movie->title }}
        </a>
        <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
            {{ $movie->year }}
        </div>
        <!-- Trailer Link -->
        <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
            <a href="{{ $movie->trailer_url }}">Watch The Trailer</a>
        </div>
        
        <!-- Synopsis -->
        <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
            {{ $movie->synopsis }}
        </div>
        

        <!-- Next Screenings -->
        <div class="font-light text-gray-700 dark:text-gray-300">
            <strong>Next Screenings:</strong>
            <ul class="list-disc list-inside mt-1">
                
            </ul>
        </div>
    </div>
</div>
