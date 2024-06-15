@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
    <div class="flex justify-center">
        <div
            class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">Cart is Empty</h3>
            @else
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-tickets.table :cart="$cart" :showView="false" :showEdit="false" :showDelete="false" :showAddCart="false"
                        :showRemoveFromCart="true" />
                </div>
                <div class="mt-12">
                    <div class="flex justify-between space-x-12 items-end">
                        <div>
                            <h3 class="mb-4 text-xl">Shopping Cart Confirmation </h3>

                            <form action="{{ route('purchases.store') }}" method="POST">
                                @csrf
                                @method('POST')
                                @if(!Auth::check())
                                <x-field.input name="costumer_name" label="Costumer Name" width="lg" :readonly="false"
                                    value="" />
                                
                                <x-field.input name="email" label="Email" width="lg" :readonly="false" value="" />
                                <br>
                                @endif
                                
                                @if (Auth::check() && !empty(Auth::user()->customer))
                                @php $user = Auth::user() @endphp
                                <x-input-label for="payment_type" :value="__('Payment Type')" />
                                <x-select-input id="payment_type" name="payment_type" class="mt-1 block w-full" required
                                    autofocus="name">
                                    @if(old('payment_type', $user->customer?->payment_type)== 'PAYPAL')
                                        <option value="PAYPAL">PayPal</option>
                                        <option value="MBWAY">MBWay</option>
                                        <option value="VISA">Visa</option>
                                    @elseif(old('payment_type', $user->customer?->payment_type)== 'MBWAY')
                                        <option value="MBWAY">MBWay</option>
                                        <option value="PAYPAL">PayPal</option>
                                        <option value="VISA">Visa</option>
                                    @elseif(old('payment_type', $user->customer?->payment_type)== 'VISA')
                                        <option value="VISA">Visa</option>    
                                        <option value="MBWAY">MBWay</option>
                                        <option value="PAYPAL">PayPal</option>
                                    @else
                                        <option value="">Choose one</option>
                                        <option value="PAYPAL">PayPal</option>
                                        <option value="MBWAY">MBWay</option>
                                        <option value="VISA">Visa</option>
                                    @endif
                                </x-select-input>

                                <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />

                                <x-input-label for="payment_ref" :value="__('Payment Reference')" />
                                <x-text-input id="payment_ref" name="payment_ref" type="text" class="mt-1 block w-full"
                                    value="{{old('payment_ref', $user->customer?->payment_ref) }}" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('payment_ref')" />


                                @else
                                <x-input-label for="payment_type" :value="__('Payment Type')" />
                                <x-select-input id="payment_type" name="payment_type" class="mt-1 block w-full" required
                                    autofocus="name">
                                    <option value="">Choose one</option>
                                    <option value="PAYPAL">PayPal</option>
                                    <option value="MBWAY">MBWay</option>
                                    <option value="VISA">Visa</option>
                                </x-select-input>

                                <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />

                                <x-input-label for="payment_ref" :value="__('Payment Reference')" />
                                <x-text-input id="payment_ref" name="payment_ref" type="text" class="mt-1 block w-full"
                                    value="" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('payment_ref')" />
                                @endif

                                <x-input-label for="payment_total" :value="__('Total To Pay')" />
                                <x-text-input id="pay_value" name="Total_pay" type="text" class="mt-3 block w-full "
                                    value="{{ $many * App\Models\Configuration::pluck('ticket_price')[0] }}"
                                    :readonly="true" />


                            
                                <x-button element="submit" type="dark" text="Confirm" class="mt-4" />
                            </form>

                            <form action="{{ route('cart.destroy') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-button element="submit" type="danger" text="Clear Cart" class="mt-4" />
                            </form>
                        </div>

                    </div>
                </div>
            @endempty
        </div>
    </div>
@endsection
