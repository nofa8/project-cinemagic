@if(count($table) > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border-b-2 px-4 py-2 text-left">Seat</th>
                    @php
                        $max = 1;
                        foreach ($table as $key => $value) {
                            if ($max < max(array_keys($value))){
                                $max = max(array_keys($value));
                            }
                        }
                    @endphp
                    @for($i = 1; $i <= $max; $i++)
                        <th class="border-b-2 px-4 py-2 text-center">{{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($table as $row => $seats)
                    <tr>
                        <td class="border-b-2 text-center">{{ $row }}</td>
                        @for($j = 1; $j <= $max; $j++)
                            <td class="border px-4 py-2 text-center">
                                <label class="inline-flex items-center">
                                    @if($seats[$j] == 'disabled')
                                    <input type="checkbox" name="seats[]" class="form-checkbox h-3 w-3 text-indigo-800/50" disabled>
                                    @else
                                    <input type="checkbox" name="seats[]" value="{{ $seatMatrix[$row][$j]}}" class="form-checkbox h-5 w-5 text-indigo-600" >
                                    @endif
                                </label>
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>No seats available.</p>
@endif
