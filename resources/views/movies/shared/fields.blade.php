@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="title" width="md"
                        :readonly="$readonly || ($mode == 'edit')"
                        value="{{ old('title', $movie->title) }}"/>
        <x-field.input name="year" label="year" :readonly="$readonly"
                        value="{{ old('name', $movie->year) }}"/>
        <x-field.text-area name="synopsis" label="Synopsis"
                        :readonly="$readonly"
                        value="{{ old('synopsis', $movie->synopsis) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="image_file"
            label="movie Image"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Image"
            :deleteAllow="($mode == 'edit') " {{--&& ($movie->imageExists) --}}
            deleteForm="form_to_delete_image"
            :imageUrl="$movie->photoFullUrl"/>
    </div>
</div>
