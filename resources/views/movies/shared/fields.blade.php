@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="px-4 py-6 md:px-16 lg:py-16 md:py-12">
    <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
        <div>
            <x-field.image
                name="image_file"
                label="Poster"
                width="lg"
                :readonly="$readonly"
                deleteTitle="Delete Poster"
                :deleteAllow="($mode == 'edit') && ($movie->imageExists)"
                deleteForm="form_to_delete_image"
                :imageUrl="$movie->imageFullUrl"/>
        </div>
        <div class="space-y-4">
            <div class="space-y-4">
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
        </div>
    </div>
    <br>
    @if($readonly)
        <x-screenings.table :screenings="$movie->screenings"
                            :showView="true"
                            :showEdit="true"
                            :showDelete="true"
                            :showAdd="true"
        />
    @endif
</div>
