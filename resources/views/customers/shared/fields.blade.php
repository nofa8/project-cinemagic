@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
    $adminReadonly = $readonly;
    if (!$adminReadonly) {
        if ($mode == 'create') {
            $adminReadonly = Auth::user()?->cannot('createAdmin', App\Models\Customer::class);
        } elseif ($mode == 'edit') {
            $adminReadonly = Auth::user()?->cannot('updateAdmin', $customer);
        } else {
            $adminReadonly = true;
        }
    }
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly"
                        value="{{ old('name', $customer->user->name) }}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly"
                        value="{{ old('email', $customer->user->email) }}"/>
        <x-field.radiogroup name="gender" label="Gender" :readonly="$readonly"
            value="{{ old('gender', $customer->user->gender) }}"
            :options="['M' => 'Masculine', 'F' => 'Feminine']"/>
        <x-field.select name="department" label="Department" :readonly="$readonly"
            value="{{ old('department', $customer->department) }}"
            :options="$departments"/>
        <div class="flex space-x-4">
            <x-field.input name="office" label="Office" :readonly="$readonly"
                        value="{{ old('office', $customer->office) }}"/>
            <x-field.input name="extension" label="Extension" :readonly="$readonly"
                        value="{{ old('extension', $customer->extension) }}"/>
            <x-field.input name="locker" label="Locker" :readonly="$readonly"
                        value="{{ old('locker', $customer->locker) }}"/>
        </div>
        <x-field.checkbox name="admin" label="Administrator" :readonly="$adminReadonly"
                        value="{{ old('admin', $customer->user->admin) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="photo_file"
            label="Photo"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($customer->user->photo_filename)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$customer->user->photoFullUrl"/>
    </div>
</div>
