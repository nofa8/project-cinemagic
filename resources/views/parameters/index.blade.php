@extends('layouts.main')

@section('header-title', 'Configuration Parameters')

@section('main')

<div class="flex flex-wrap -mx-3">

    <div class="w-full md:w-1/2 px-3">
        <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
            <div class="md:flex">
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Current Ticket Price</div>
                    <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">
                        {{ number_format($configuration->ticket_price, 2) }} €</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-1/2 px-3">
        <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
            <div class="md:flex">
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Current Ticket Discount</div>
                    <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">
                        {{ $configuration->registered_customer_ticket_discount }} €</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-wrap -mx-3 mt-8">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
            <form action="{{ route('updateTicketPrice') }}" method="POST">
                @csrf
                <label for="ticketPrice" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Update Ticket Price</label>
                <input type="number" name="ticketPrice" id="ticketPrice" class="mt-1 p-2 bg-white border shadow-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 block w-full rounded-md" placeholder="Enter new ticket price">
                <button type="submit" class="mt-4 px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update Price</button>
            </form>
        </div>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
            <form action="{{ route('updateDiscount') }}" method="POST">
                @csrf
                <label for="ticketDiscount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Update Ticket Discount</label>
                <input type="number" name="ticketDiscount" id="ticketDiscount" class="mt-1 p-2 bg-white border shadow-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 block w-full rounded-md" placeholder="Enter new ticket discount">
                <button type="submit" class="mt-4 px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update Discount</button>
            </form>
        </div>
    </div>
</div>

@endsection
