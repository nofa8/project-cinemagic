<table class="table-auto border-collapse">
    <thead>
    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
        <th class="px-2 py-2 text-left hidden sm:table-cell">Movie</th>
        <th class="px-2 py-2 text-left">Theater</th>
        <th class="px-2 py-2 text-right hidden md:table-cell">Screening Date</th>
        <th class="px-2 py-2 text-right hidden md:table-cell">Screening Hour</th>
        <th class="px-2 py-2 text-right hidden lg:table-cell">Row</th>
        <th class="px-2 py-2 text-right hidden lg:table-cell">Seat</th>
        <th class="px-2 py-2 text-right hidden lg:table-cell">Price</th>
        @if($showView)
            <th></th>
        @endif
    </tr>
    </thead>
    <tbody>
        @php
        $value = App\Models\Configuration::pluck('ticket_price')[0]
        @endphp
    @foreach ($tickets as $ticket)
        <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
            <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $ticket->screening->movie->title }}</td>
            <td class="px-2 py-2 text-left">{{  $ticket->screening->theater->name }}</td>
            <td class="px-2 py-2 text-right hidden md:table-cell">{{ $ticket->screening->date }}</td>
            <td class="px-2 py-2 text-right hidden md:table-cell">{{ $ticket->screening->start_time }}</td>
            <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $ticket->seat->row }}</td>
            <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $ticket->seat->seat_number }}</td>
            <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $value}}</td>
            @if($showView)
                <td class="px-2 py-2 text-right">
                    <x-table.icon-show class="ps-3 px-0.5" href="{{ route('tickets.show', ['ticket' => $ticket]) }}"/>
                </td>
            @else
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
