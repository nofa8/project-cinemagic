@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<x-field.select name="movie_id" label="Movie" :readonly="$readonly"
    value="{{ old('movie_id', $screening->movie_id) }}"
    :options="$movies->pluck('name', 'id')->toArray()"/>


<x-field.select name="theater_id" label="Theater" :readonly="$readonly"
    value="{{ old('theater_id', $screening->theater_id) }}"
    :options="$theaters->pluck('name', 'id')->toArray()"/>

<x-field.input name="date" label="Date" :readonly="$readonly"
                value="{{ old('date', $screening->date) }}"/>

<x-field.input name="start_time" label="Start Time" :readonly="$readonly"
                value="{{ old('start_time', $screening->start_time) }}"/>





                
