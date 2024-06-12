@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title" :readonly="$readonly"
                       value="{{ old('title', $movie->title) }}"/>
        <x-field.select name="genre_code" label="Genre" :readonly="$readonly"
                        value="{{ old('genre', $movie->genre_code) }}"
                        :options="\App\Models\Genre::all()->pluck('name','code')->toArray()"/>
        <x-field.input name="year" label="Year" :readonly="$readonly"
                       value="{{ old('year', $movie->year) }}"/>
        <x-field.text-area name="synopsis" label="Synopsis" :readonly="$readonly"
                           value="{{ old('synopsis', $movie->synopsis) }}"/>
        <x-movies.trailer url="{{ $movie->trailer_url }}" show="{{ $readonly }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="image_file"
            label="Poster"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Poster"
            :deleteAllow="($mode == 'edit') && ($movie->imageExists)"
            deleteForm="form_to_delete_image"
            :imageUrl="$movie->imageFullUrl"/>
    </div>
    @if($readonly)
            <x-screenings.table :screenings="$movie->screenings"
                                :showView="true"
                                :showEdit="true"
                                :showDelete="true"
                                :showAdd="true"
            />
        @endif
</div>