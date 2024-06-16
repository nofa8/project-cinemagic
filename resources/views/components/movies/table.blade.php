@if (!$trash)
<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Title</th>
            <th class="px-2 py-2 text-left">Synopsis</th>
            <th class="px-2 py-2 text-left">Genre</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($movies as $movie)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                </td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $movie->title }}</td>
                <td class="px-2 py-2 text-left">{{ $movie->synopsis }}</td>
                <td class="px-2 py-2 text-left">{{ $movie->genre_code }}</td>
                
                @if($showView)
                    @can('view', $movie)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5" href="{{ route('movies.show', ['movie' => $movie]) }}" />
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $movie)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                            href="{{ route('movies.edit', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $movie)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('movies.destroy', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@else
<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Title</th>
            <th class="px-2 py-2 text-left">Synopsis</th>
            <th class="px-2 py-2 text-left">Genre</th>
            @if($showDelete)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($movies as $movie)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                </td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $movie->title }}</td>
                <td class="px-2 py-2 text-left">{{ $movie->synopsis }}</td>
                <td class="px-2 py-2 text-left">{{ $movie->genre_code }}</td>
                @if($showDelete)
                    @can('delete', $movie)
                        <td>
                            <x-table.icon-save class="px-0.5"
                            action="{{ route('movies.save', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $movie)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('movies.permanent-delete', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                
                @if($showDelete)
                    @can('delete', $movie)
                    <style>
                        .dangerous-element {
                            position: relative;
                        }
                
                        .dangerous-text {
                            opacity: 0;
                            position: absolute;
                            transform: translateX(-40%) translateY(10px);
                            background-color: rgba(0, 0, 0, 0.8);
                            color: #fff;
                            padding: 0.5rem 1rem;
                            border-radius: 0.25rem;
                            white-space: nowrap;
                            transition: all 0.1s ease;
                            font-weight: bold;
                        }
                
                        .dangerous-element:hover .dangerous-text {
                            opacity: 1;
                            transform: translateX(-70%) translateY(0.1rem);
                        }
                    </style>
                        <td class="relative">
                            <div class="dangerous-element inline-block px-0.5 bg-red-600 text-white rounded cursor-pointer hover:bg-red-800">
                                <x-table.icon-delete action="{{ route('movies.permanent-delete-forced', ['movie' => $movie]) }}" />
                                <div class="dangerous-text">Will force to delete everything!</div>
                            </div>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
