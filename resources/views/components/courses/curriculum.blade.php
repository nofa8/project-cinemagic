<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
            <tr>
                <th class="border-2 border-gray-400 dark:border-gray-500 py-1 px-3 bg-gray-100 dark:bg-gray-800">Theater</th>
                <th class="py-1 px-3 border-y-2 border-e-2 border-y-gray-400 dark:border-y-gray-500 border-e-gray-400 dark:border-e-gray-500 bg-gray-100 dark:bg-gray-800">Date</th>
                <th class="py-1 px-3 border-y-2 border-e-2 border-y-gray-400 dark:border-y-gray-500 border-e-gray-400 dark:border-e-gray-500 bg-gray-100 dark:bg-gray-800">Time</th>
                <th class="py-1 px-3 border-y-2 border-e-2 border-y-gray-400 dark:border-y-gray-500 border-e-gray-400 dark:border-e-gray-500 bg-gray-100 dark:bg-gray-800">Movie</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curriculum as $theaterId => $dates)
                @foreach ($dates as $date => $times)
                    @foreach ($times as $startTime => $screenings)
                        @foreach ($screenings as $screening)
                            <tr>
                                @if ($loop->parent->parent->first && $loop->first)
                                    <th class="py-1 px-3 border-b-2 border-x-2 border-b-gray-400 dark:border-b-gray-500
                                                border-x-gray-400 dark:border-x-gray-500
                                                bg-gray-100 dark:bg-gray-800"
                                        rowspan="{{ $dates->flatten()->count() }}">
                                        {{ $theaters->find($theaterId)->name }}
                                    </th>
                                @endif
                                @if ($loop->parent->first && $loop->first)
                                    <th class="py-1 px-3 border-b-2 border-x-2 border-b-gray-400 dark:border-b-gray-500
                                                border-x-gray-400 dark:border-x-gray-500
                                                bg-gray-100 dark:bg-gray-800"
                                        rowspan="{{ $times->flatten()->count() }}">
                                        {{ $date }}
                                    </th>
                                @endif
                                @if ($loop->first)
                                    <th class="py-1 px-3 border-b-2 border-x-2 border-b-gray-400 dark:border-b-gray-500
                                                border-x-gray-400 dark:border-x-gray-500
                                                bg-gray-100 dark:bg-gray-800"
                                        rowspan="{{ count($screenings) }}">
                                        {{ $startTime }}
                                    </th>
                                @endif
                                <td class="py-1 px-3 text-sm
                                            border border-b-2 border-b-gray-400 dark:border-b-gray-500
                                            border-e-2 border-e-gray-400 dark:border-e-gray-500">
                                    @can('view', $screening->movie)
                                        <a href="{{ route('movies.show', ['movie' => $screening->movie->id]) }}">
                                            {{ $screening->movie->title }}
                                        </a>
                                    @else
                                        {{ $screening->movie->title }}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
