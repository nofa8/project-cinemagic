<div {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="table-auto border-collapse w-full shadow-lg">
        <thead>
            <tr>
                <th class="border-2 border-gray-400 dark:border-gray-500 py-2 px-4 bg-gray-200 dark:bg-gray-800 text-left text-gray-700 dark:text-gray-200 font-semibold">Theater</th>
                @foreach($table as $key=>$dates)
                @foreach($dates as $date=>$whatever)
                    <th class="py-2 px-4 border-2 border-gray-400 dark:border-gray-500 bg-gray-200 dark:bg-gray-800 text-center text-gray-700 dark:text-gray-200 font-semibold">{{ $date }}</th>
                @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $theater => $rowsDate)
                @php
                    $maxRows = max(array_map('count', $rowsDate));
                @endphp
                @for ($i = 0; $i < $maxRows; $i++)
                    <tr class="bg-white dark:bg-gray-900 even:bg-gray-50 dark:even:bg-gray-800">
                        @if ($i == 0)
                            <th class="text-center py-2 px-4 border-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-700  text-gray-800 dark:text-gray-300" rowspan="{{ $maxRows }}">
                                {{ \App\Models\Theater::where('id',$theater)->pluck('name')[0] }}
                            </th>
                        @endif
                        @foreach($rowsDate as $date => $screenings)
                            @if (isset($screenings[$i]))
                                <td class="py-2 px-4 text-sm border-2 border-gray-300 dark:border-gray-600 text-center">
                                    <a href="{{ route('screenings.seats', ['screenings' => $screenings[$i]->id]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $screenings[$i]->start_time }}
                                    </a>
                                </td>
                            @else
                                @if($i != $maxRows-1)
                                    <td class="py-2 px-4 text-sm border-2 border-gray-300 dark:border-gray-600 dark:border-y-transparent border-y-transparent">
                                        <!-- Empty Cell -->
                                    </td>
                                    @else
                                    <td class="py-2 px-4 text-sm border-2 border-gray-300 dark:border-gray-600 dark:border-t-transparent border-t-transparent">
                                        <!-- Empty Cell -->
                                    </td>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table>
</div>
