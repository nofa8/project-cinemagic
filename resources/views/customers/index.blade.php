@extends('layouts.main')

@section('header-title', 'List of Customers')

@section('main')
    @php
        $trash = $tr ?? false;
    @endphp
    @if (!$trash == 'trash')
        {{-- @can('create', App\Models\Movie::class)
        <div class="flex items-center gap-4 mb-4">
            <x-button href="{{ route('customers.create') }}" text="Create a new Customer" type="success" />
        </div>
    @endcan --}}
        <x-customers.filter-card :filterAction="route('customers.index')" :resetUrl="route('customers.index')" :name="old('name', $filterByName)" class="mb-6" />
        <div class="grid grid-cols-1 gap-5">
            @each('customers.shared.cards', $customers, 'customers')
        </div>
        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    @else
        <x-customers.filter-card :filterAction="route('customers.deleted')" :resetUrl="route('customers.deleted')" :name="old('name', $filterByName)" class="mb-6" />
        <div class="grid grid-cols-1 gap-5">
            @each('customers.shared.cards', $customers, 'customers')
        </div>
        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    @endif
@endsection
