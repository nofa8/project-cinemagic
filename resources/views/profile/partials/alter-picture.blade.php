@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<section>
    <header class="text-lg font-medium text-gray-900 dark:text-gray-100">
        <h2>{{ __('Profile Picture') }}</h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.image') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mt-6">
            <x-field.image
                name="photo_filename"
                label="Photo"
                width="md"
                :readonly="$readonly"
                deleteTitle="Delete Photo"
                :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                deleteForm="form_to_delete_photo"
                imageUrl="{{ Auth::user()?->photoFullUrl ? Auth::user()->photoFullUrl : Vite::asset('resources/img/photos/default.png')}}"
                imgClass="rounded-full"
            />
        </div>

        <div class="mt-6">
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
