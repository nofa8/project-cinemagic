@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="m-4 p-4">
    <x-field.input name="name" label="Name" :readonly="$readonly"
                value="{{ old('name', $theater->name) }}"/>
</div>
<div class="m-4 p-4">
    <x-field.image
        name="photo_filename"
        label="photo_filename"
        width="lg"
        :readonly="$readonly"
        deleteTitle="Delete Photo"
        :deleteAllow="($mode == 'edit') && ($theater->imageExists)"
        deleteForm="form_to_delete_image"
        :imageUrl="$theater->imageFullUrl"/>
        
</div>