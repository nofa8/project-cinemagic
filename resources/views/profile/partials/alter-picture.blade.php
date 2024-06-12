@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<header class="text-lg font-medium text-gray-900 dark:text-gray-100">
    <h2>{{ __('Profile Picture') }}</h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile picture.") }}
    </p>
</header>
<div class="mt-6">
    <x-field.image
        name="photo_file"
        label="Photo"
        width="md"
        :readonly="$readonly"
        deleteTitle="Delete Photo"
        :deleteAllow="true"
        deleteForm="form_to_delete_photo"
        imageUrl="{{ $user->getPhotoFullUrlAttribute() }}"
        imgClass="rounded-full"
    />
</div>
    