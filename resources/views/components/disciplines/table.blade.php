<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden sm:table-cell">Movie</th>
            <th class="px-2 py-2 text-left">Theater</th>
            <th class="px-2 py-2 text-right hidden md:table-cell">Date</th>
            <th class="px-2 py-2 text-right hidden md:table-cell">Hour</th>
            <th class="px-2 py-2 text-right hidden lg:table-cell">Row</th>
            <th class="px-2 py-2 text-right hidden lg:table-cell">Seat</th>
            <th class="px-2 py-2 text-right hidden lg:table-cell">Price</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($cart as $cartItem)
            @php

                $screening = \App\Models\Screening::findOrFail($cartItem['screening_id']);
                $movie = $screening->movie;
                $theater = $screening->theater;
                $seat = \App\Models\Seat::find($cartItem['seat_id']);
            @endphp
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $movie->title }}</td>
                <td class="px-2 py-2 text-left">{{ $theater->name }}</td>
                <td class="px-2 py-2 text-right hidden md:table-cell">{{ $screening->date }}</td>
                <td class="px-2 py-2 text-right hidden md:table-cell">{{ $screening->start_time }}</td>
                <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $seat->row }}</td>
                <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $seat->seat_number }}</td>
                <td class="px-2 py-2 text-right hidden lg:table-cell">{{ App\Models\Configuration::get('ticket_price')}}</td>
                @if($showView)
                    <td class="px-2 py-2 text-right">
                        <a href="{{ route('cart.view', $cartItem->id) }}" class="text-blue-500">View</a>
                    </td>
                @endif
                @if($showEdit)
                    <td class="px-2 py-2 text-right">
                        <a href="{{ route('cart.edit', $cartItem->id) }}" class="text-yellow-500">Edit</a>
                    </td>
                @endif
                @if($showDelete)
                    <td class="px-2 py-2 text-right">
                        <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
