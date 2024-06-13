<!-- resources/views/movies/shared/card.blade.php -->

<div class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
    <!-- Poster on the left -->
    <a class="h-50 w-48 flex-shrink-0 " href="{{ route('screenings.show', ['screening' => $screening]) }}">
        <img class="h-full w-full object-cover pe-4"
            src="{{ $screening->movie->imageFullUrl }}">
    </a>

    <!-- Content on the right -->
    <div class="flex flex-col justify-center w-full">
        <!-- Title -->
        <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2" href="{{ route('screenings.show', ['screening' => $screening]) }}">
            {{ $screening->movie->title }}
        </a>



        <div class="flex flex-col justify-center w-full">
            <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
                {{ $screening->movie->year }}
            </div>
            <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                    {{ $screening->movie->genreRef->name}}
            </div>
            <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                {{ $screening->date}}
            </div>
            <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                {{ $screening->start_time}}
            </div>
            
        </div>

        <!-- Synopsis -->
        


        <!-- Next Screenings -->
        
    </div>
</div>
