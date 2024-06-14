@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<x-field.input name="date" label="Date" :readonly="$readonly" value="{{ $screening->date }}" />

<x-field.input name="start_time" label="Start Time" :readonly="$readonly"
    value="{{ $screening->start_time }}" />


<form method="post" action="{{ route('tickets.verify', ['screening' => $screening]) }}" class="mt-6 space-y-6">
    @csrf

    <div>
        <x-input-label for="ticket_id" :value="__('Ticket ID')" />
        <x-text-input id="ticket_id" name="ticket_id" type="text" class="mt-1 block w-full" />
        <x-input-error class="mt-2" :messages="$errors->get('ticket_id')" />
    </div>
    
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Verify') }}</x-primary-button>
    </div>
</form>

