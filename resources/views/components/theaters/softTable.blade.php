<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Name</th>
            <th class="px-2 py-2 text-left">Name</th>
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
                @if($showEdit)
                    @can('delete', $theater)
                        <td>
                            <x-table.icon-save class="px-0.5"
                            action="{{ route('theaters.save', ['theater' => $theater]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $theater)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('theaters.permanent-delete', ['theater' => $theater]) }}"/>
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
