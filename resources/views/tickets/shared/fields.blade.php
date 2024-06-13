@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<x-field.input name="qrcode_url" label="QR Code URL" :readonly="$readonly || ($mode == 'edit')"
               value="{{ old('qrcode_url', $ticket->qrcode_url) }}"/>

<x-field.select name="status" label="Status" :readonly="$readonly" :options="['valid' => 'Valid', 'invalid' => 'Invalid']"
                value="{{ old('status', $ticket->status) }}"/>

<x-field.input name="price" label="Price" :readonly="$readonly" type="number" step="0.01"
               value="{{ old('price', $ticket->price) }}"/>
