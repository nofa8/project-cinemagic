@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<section>
    <header class="text-lg font-medium text-gray-900 dark:text-gray-100">
        <h2>{{ __('Profile Information') }}</h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="mt-6">
        @csrf
    </form>

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
                @if(old('payment_type', $user->customer?->payment_type) == null)
                    <option value="option1">Choose one</option>
                    <option value="option2">MBWay</option>
                    <option value="option3">Visa</option>
                    <option value="option4">PayPal</option>
                @endif
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />
        </div>

        <div>
            <x-input-label for="payment_ref" :value="__('Payment Reference')" />
            <x-text-input id="payment_ref" name="payment_ref" type="text" class="mt-1 block w-full" :value="old('payment_ref', $user->customer?->payment_ref)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('payment_ref')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p>
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-blue-500">{{ __('Click here to re-send the verification email.') }}</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600">{{ __('A new verification link has been sent to your email address.') }}</p>
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

    </form>
</section>
