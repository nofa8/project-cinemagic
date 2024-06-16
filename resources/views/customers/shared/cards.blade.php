@if (!$customers->trashed())
    @if ($customers->user->type == 'C')

        <div
            class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Poster on the left -->
            <a class="h-50 w-48 flex-shrink-0 ">
                <img class="h-full w-full object-cover pe-4" src="{{ $customers->user->photoFullUrl }}">
            </a>

            <!-- Content on the right -->
            <div class="flex flex-col justify-center w-full">
                <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2">
                    {{ $customers->user->name }}
                </a>

                <div class="flex flex-col justify-center w-full">
                    {{-- @if (!empty($customers->nif))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
                            NIF: {{ $customers->nif }}
                        </div>
                    @endif

                    @if (!empty($customers->payment_type))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                            Payment Type: {{ $customers->payment_type }}
                        </div>
                    @endif

                    @if (!empty($customers->payment_ref))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                            Payment Reference: {{ $customers->payment_ref }}
                        </div>
                    @endif

                    @if (!empty($customers->user->email))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                            Email: {{ $customers->user->email }}
                        </div>
                    @endif --}}

                    @if ($customers->user->blocked == 0)
                    <div class="flex items-center space-x-4 mb-2">
                        <span class="font-light text-gray-700 dark:text-gray-300">Not Blocked</span>
                        <form action="{{ route('customers.invert', ['customer'=> $customers]) }}" method="POST">
                            @csrf
                            <x-button element="submit" text="Block"  type="danger"/>
                        </form>
                    </div>
                    @else
                    <div class="flex items-center space-x-4 mb-2">
                        <span class="font-light text-gray-700 dark:text-gray-300">Blocked</span>
                        <form action="{{ route('customers.invert', ['customer'=> $customers]) }}" method="POST">
                            @csrf
                            <x-button element="submit" text="Unblock"  type="success"/>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    @endif
@else
    @if ($customers->userD->type == 'C')

        <div
            class="flex flex-col sm:flex-row items-center bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Poster on the left -->
            <a class="h-50 w-48 flex-shrink-0 ">
                <img class="h-full w-full object-cover pe-4" src="{{ $customers->userD->photoFullUrl }}">
            </a>

            <!-- Content on the right -->
            <div class="flex flex-col justify-center w-full">
                <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-2">
                    {{ $customers->userD->name }}
                </a>

                <div class="flex flex-col justify-center w-full">
                    {{-- @if (!empty($customers->nif))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2">
                            NIF: {{ $customers->nif }}
                        </div>
                    @endif

                    @if (!empty($customers->payment_type))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                            Payment Type: {{ $customers->payment_type }}
                        </div>
                    @endif

                    @if (!empty($customers->payment_ref))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                            Payment Reference: {{ $customers->payment_ref }}
                        </div>
                    @endif

                    @if (!empty($customers->userD->email))
                        <div class="font-light text-gray-700 dark:text-gray-300 mb-2 inline">
                            Email: {{ $customers->userD->email }}
                        </div>
                    @endif --}}

                    @if ($customers->userD->blocked == 0)
                        <div class="flex items-center space-x-4 mb-2">
                            <span class="font-light text-gray-700 dark:text-gray-300">Not Blocked</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-4 mb-2">
                            <span class="font-light text-gray-700 dark:text-gray-300">Blocked</span>
                        </div>
                    @endif

                <div class="flex justify-start mb-auto">
                    <td class=" py-2">
                        <x-table.icon-save class="text-gray-400 hover:text-white px-2 py-1 rounded"
                            action="{{ route('customers.save', ['customer' => $customers]) }}" />
                    </td>
                    <td class=" py-2">
                        <x-table.icon-delete class="text-red-400 hover:text-red-700 px-2 py-1 rounded"
                            action="{{ route('customers.permanent-delete', ['customer' => $customers]) }}" />
                    </td>
                </div>
            </div>
        </div>
    </div>
    @endif
@endif
