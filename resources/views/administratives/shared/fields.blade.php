@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
    $adminReadonly = $readonly;

    $options = [
        'A' => 'Administrative',
        'E' => 'Employee',
    ];

    if (!$adminReadonly) {
        if ($mode == 'create') {
            $adminReadonly = Auth::user()?->cannot('createAdmin', App\Models\User::class);
        } elseif ($mode == 'edit') {
            $adminReadonly = Auth::user()?->cannot('updateAdmin', $administrative);
        } else {
            $adminReadonly = true;
        }
    }
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly"
                        value="{{ old('name', $administrative->name) }}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly"
                        value="{{ old('email', $administrative->email) }}"/>
        <div class="flex items-center space-x-4">
            <x-field.radio-group name="type" label="Type" :options="$options" :value="old('type', $administrative->type)" :readonly="$readonly"/>
        </div>
    </div>
    <div class="pb-6">
        <x-field.image
            name="photo_file"
            label="Photo"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($administrative->photoFullUrl)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$administrative->photoFullUrl"/>
    </div>
</div>
