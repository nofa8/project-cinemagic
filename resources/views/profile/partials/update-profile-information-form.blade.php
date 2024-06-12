<<<<<<< HEAD
.....
afonnn
Invisible
Rafa RBR, broscout

.....
 added 
broscout
 to the group.
 — Today at 13:07
..... — Today at 13:07
arroz
broscout — Today at 13:08
public function confirm(CartConfirmationFormRequest $request)
    {
        $cart = session('cart', []);
        if (!$cart || (count($cart) == 0)) {
            return back()
                ->with('alert-type', 'danger')
Expand
message.txt
4 KB
https://dev.to/snehalkadwe/use-of-dompdf-in-laravel-10-opn
DEV Community
Use of DomPDF in Laravel 10
Hello Artisans, In the world of web development it's quite common to have the need, for generating...
Use of DomPDF in Laravel 10
fazer o pdf
e fazer isto
menos o passo 3
e fazer store do ficheiro
no step 5
a stora diz que e so copiar e mudar a rota para purchase
Rafa RBR — Today at 13:37
<img class="h-full w-full object-cover"
            src="{{ $user->photo_filename }}"> 
Rafa RBR — Today at 13:51
@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Profile Information') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile information.") }}
    </p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>
<div>
    <div>
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="nif" :value="__('NIF')" />
                        <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->customer?->nif)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('nif')" />
                    </div>

                    <div>
                        <x-input-label for="payment_type" :value="__('Payment Type')" />
                        <x-select-input id="payment_type" name="payment_type" class="mt-1 block w-full" required autofocus="name">
                            @if(old('payment_type', $user->customer?->payment_type) == 'PAYPAL')
                                <option value="option1">PayPal</option>
                                <option value="option2">MBWay</option>
                                <option value="option3">Visa</option>
                            @endif
                            @if(old('payment_type', $user->customer?->payment_type) == 'VISA')
                                <option value="option1">Visa</option>
                                <option value="option2">MBWay</option>
                                <option value="option3">PayPal</option>
                            @endif
                            @if(old('payment_type', $user->customer?->payment_type) == 'MBWAY')
                                <option value="option1">MBWay</option>
                                <option value="option2">Visa</option>
                                <option value="option3">PayPal</option>
                            @endif
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </div>

                <div class="ml-6 ">
... (8 lines left)
Collapse
message.txt
6 KB
﻿
@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Profile Information') }}
    </h2>
=======
@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Profile Information') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile information.") }}
    </p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>
<div>
    <div>
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="nif" :value="__('NIF')" />
                <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->customer?->nif)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('nif')" />
            </div>

            <div>
                <x-input-label for="payment_type" :value="__('Payment Type')" />
                <x-select-input id="payment_type" name="payment_type" class="mt-1 block w-full" required autofocus="name">
                    @if(old('payment_type', $user->customer?->payment_type) == 'PAYPAL')
                        <option value="option1">PayPal</option>
                        <option value="option2">MBWay</option>
                        <option value="option3">Visa</option>
                    @endif
                    @if(old('payment_type', $user->customer?->payment_type) == 'VISA')
                        <option value="option1">Visa</option>
                        <option value="option2">MBWay</option>
                        <option value="option3">PayPal</option>
                    @endif
                    @if(old('payment_type', $user->customer?->payment_type) == 'MBWAY')
                        <option value="option1">MBWay</option>
                        <option value="option2">Visa</option>
                        <option value="option3">PayPal</option>
                    @endif
                </x-select-input>
                <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
            <div class="pb-6">
                <x-field.image
                    name="photo_file"
                    label="Photo"
                    width="md"
                    :readonly="$readonly"
                    deleteTitle="Delete Photo"
                    :deleteAllow="true"
                    deleteForm="form_to_delete_photo"
                    imageUrl="$user->photoFullUrl"/>
            </div>
        </form>
    </div>
</div>

>>>>>>> aa2e79a1a39d6313f7721c6b9fcfd9ddb99c2fff

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile information.") }}
    </p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>
<div>
    <div>
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="nif" :value="__('NIF')" />
                        <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->customer?->nif)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('nif')" />
                    </div>

                    <div>
                        <x-input-label for="payment_type" :value="__('Payment Type')" />
                        <x-select-input id="payment_type" name="payment_type" class="mt-1 block w-full" required autofocus="name">
                            @if(old('payment_type', $user->customer?->payment_type) == 'PAYPAL')
                                <option value="option1">PayPal</option>
                                <option value="option2">MBWay</option>
                                <option value="option3">Visa</option>
                            @endif
                            @if(old('payment_type', $user->customer?->payment_type) == 'VISA')
                                <option value="option1">Visa</option>
                                <option value="option2">MBWay</option>
                                <option value="option3">PayPal</option>
                            @endif
                            @if(old('payment_type', $user->customer?->payment_type) == 'MBWAY')
                                <option value="option1">MBWay</option>
                                <option value="option2">Visa</option>
                                <option value="option3">PayPal</option>
                            @endif
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </div>

                <div class="ml-6 ">
                    <img class="h-32 w-32 object-cover rounded-full"
                         src="{{ $user->photoFullUrl }}"> 
                </div>
            </div>
        </form>
    </div>
</div>
