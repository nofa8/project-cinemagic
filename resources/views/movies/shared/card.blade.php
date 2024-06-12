<!-- resources/views/movies/shared/card.blade.php -->

<div class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
    <!-- Poster on the left -->
    <a class="h-48 w-48 flex-shrink-0" href="{{ route('movies.show', ['movie' => $movie]) }}">
        <img class="h-full w-full object-cover"
            src="{{ $movie->imageFullUrl }}">
    </a>

    <!-- Content on the right -->
    <div class="flex flex-col justify-center w-full">
        <!-- Title -->
        <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2" href="{{ route('movies.show', ['movie' => $movie]) }}">
            {{ $movie->title }}
        </a>



        <div class="flex flex-col justify-center w-full">
            <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
                {{ $movie->year }}
            </div>
            <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                    {{ $movie->genreRef->name}}
            </div>
            <!-- Trailer Link -->
            <div class=" text-blue-600  dark:text-blue-400 mb-2 font-bold">
                <a href="{{ $movie->trailer_url }}">Watch The Trailer</a>
            </div>
        </div>

        <!-- Synopsis -->
        <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
            {{ $movie->synopsis }}
        </div>


        <!-- Next Screenings -->
        <div class="font-light text-gray-700 dark:text-gray-300">
            <strong>Next 3 Screenings:</strong>
            <div class="mt-1">
                @foreach ($movie->screenings()->whereBetween('date', [now(), now()->addDays(14)])->orderBy('date')->take(3)->get() as $screening)
                    @php
                        // Concatenate date and time strings
                        $dateTimeString = $screening->date . ' ' . $screening->start_time;
                        // Create a DateTime object
                        $dateTime = new DateTime($dateTimeString);
                    @endphp
                    <div class="mr-2 bg-gray-100 dark:bg-gray-800 rounded-lg p-2" style="display: inline-block;">
                        <div class="text-gray-600 dark:text-gray-400" style="display: inline;">{{ $dateTime->format('F j, Y') }}</div>
                        <div class="text-gray-600 dark:text-gray-400" style="display: inline;">{{ $dateTime->format('g:i a') }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
