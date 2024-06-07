@if($show)
    {{--<x-button
        href="{{ $url }}"
        text="See trailer"
        type="success"/>--}}
    <div class="bg-grey-950 text-grey p-4 h-96 sm:h-112 md:h-128 lg:h-144">
        <iframe
            class="h-full w-full rounded-lg"
            src="{{ Str::replace('watch?v=', 'embed/', $url) }}"
            width="100%"
            height="100%"
            title="Trailer of movie"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
    </div>
@else
    <x-field.input name="trailer_url" label="Trailer" :readonly="$show"
                   value="{{ old('trailer_url', $url) }}"/>
@endif