<div>
    <figure class="h-96 w-72 flex flex-col items-center
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900
                    my-4 p-4">
        <a class="h-48 w-48" href="{{ route('movies.show', ['movie' => $movie]) }}">
            <img class="h-full w-full object-cover mx-auto rounded-full"
                src="{{ $movie->poster_filename }}">
        </a>
        <div class="h-48 w-full p-4 text-center space-y-1 flex flex-col items-center justify-center">
            <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight" href="{{ route('movies.show', ['movie' => $movie]) }}">
                {{ $movie->title }}
            </a>
            <figcaption class="font-medium">
                <div class="font-light text-gray-700 dark:text-gray-300">
                    <a href="{{ $movie->trailer_url }}">Watch The Trailer</a>
                </div>
            </figcaption>
            
        </div>
    </figure>
</div>
