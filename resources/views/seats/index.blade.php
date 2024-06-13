@extends('layouts.main')

@section('header-title', 'List of Seats')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <!-- Replace with Seat Filter Card if applicable -->
            <div class="mb-6">
                <!-- Example of a filter card for seats -->
                <form action="{{ route('seats.index') }}" method="GET">
                    <!-- Add your filter inputs here -->
                    <div class="flex items-center gap-4">
                        <label for="filter_seat_number" class="font-medium">Seat Number:</label>
                        <input type="text" name="seat_number" id="filter_seat_number" class="form-input"
                               value="{{ old('seat_number') }}">
                        <!-- Add more filters as needed -->
                        <x-button type="submit" text="Filter" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"/>
                        <a href="{{ route('seats.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            
            @can('create', App\Models\Seat::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('seats.create') }}"
                        text="Create a new seat"
                        type="success"/>
                </div>
            @endcan

            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <!-- Example of a table for seats -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seat Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <!-- Add more headers as needed -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($seats as $seat)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $seat->seat_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $seat->status }}</td>
                                <!-- Add more columns as needed -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Example actions for each seat -->
                                    <x-button href="{{ route('seats.show', ['seat' => $seat]) }}" text="View" type="info" class="mr-2"/>
                                    <x-button href="{{ route('seats.edit', ['seat' => $seat]) }}" text="Edit" type="warning" class="mr-2"/>
                                    <!-- Add delete button if authorized -->
                                    @can('delete', $seat)
                                        <form method="POST" action="{{ route('seats.destroy', ['seat' => $seat]) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-button element="submit" text="Delete" type="danger" onclick="return confirm('Are you sure you want to delete this seat?')" />
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <!-- Pagination links -->
                {{ $seats->links() }}
            </div>
        </div>
    </div>
@endsection
