@extends('layouts.main')

@section('header-title', 'List of Customers')

@section('main')

    {{-- @can('create', App\Models\Movie::class)
        <div class="flex items-center gap-4 mb-4">
            <x-button href="{{ route('customers.create') }}" text="Create a new Customer" type="success" />
        </div>
    @endcan --}}
    <x-customers.filter-card :filterAction="route('customers.index')" :resetUrl="route('customers.index')"
        :name="old('name', $filterByName)" class="mb-6" />
    <div class="grid grid-cols-1 gap-5">
        @each('customers.shared.cards', $customers, 'customers')
    </div>
    <div class="mt-4">
        {{ $customers->links() }}
    </div>

@endsection
