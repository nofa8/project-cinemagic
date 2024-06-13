@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<x-field.input name="seat_number" label="Seat Number" :readonly="$readonly"
                value="{{ old('seat_number', $seat->seat_number) }}"/>
<x-field.input name="row" label="Row Character" :readonly="$readonly"
    value="{{ old('row', $seat->row) }}"/>

