@if($customers->user->type == 'C')
    <div class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
        <!-- Poster on the left -->
        <a class="h-50 w-48 flex-shrink-0 ">
            <img class="h-full w-full object-cover pe-4" src="{{ $customers->user->photoFullUrl }}">
        </a>

        <!-- Content on the right -->
        <div class="flex flex-col justify-center w-full">
            <!-- Title -->
            <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2">
                {{ $customers->user->name }}
            </a>

            <div class="flex flex-col justify-center w-full">
                @if(!empty($customers->nif))
                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
                        NIF: {{ $customers->nif }}
                    </div>
                @endif

                @if(!empty($customers->payment_type))
                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                        Payment Type: {{ $customers->payment_type }}
                    </div>
                @endif

                @if(!empty($customers->payment_ref))
                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                        Payment Reference: {{ $customers->payment_ref }}
                    </div>
                @endif

                @if(!empty($customers->user->email))
                    <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                        Email: {{ $customers->user->email }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endif

