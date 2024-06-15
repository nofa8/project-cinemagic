<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if (session('alert-msg'))
            <x-alert type="{{ session('alert-type') ?? 'info' }}">
                {!! session('alert-msg') !!}
            </x-alert>
        @endif
        @if (!$errors->isEmpty())
                <x-alert type="warning" message="Operation failed because there are validation errors!"/>
        @endif
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.alter-picture')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    <form method="POST" class="hidden" action="{{ route('profile.destroy.image') }}" id="form_to_delete_photo">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>
