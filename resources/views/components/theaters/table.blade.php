<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Name</th>
            <th class="px-2 py-2 text-left">Number of Seats</th>
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
        @foreach ($theaters as $theater)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $theater->name }}</td>
                <td class="px-2 py-2 text-center">{{ $theater->seats->count() }}</td>
                @if($showView)
                    @can('view', $theater)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('theaters.show', ['theater' => $theater]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $theater)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                href="{{ route('theaters.edit', ['theater' => $theater]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $theater)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('theaters.destroy', ['theater' => $theater]) }}"/>
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
