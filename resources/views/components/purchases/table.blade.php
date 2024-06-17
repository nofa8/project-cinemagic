<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            @if($showCustomer)
            <th class="px-2 py-2 text-center">Name</th>
            @endif
            <th class="px-2 py-2 text-left hidden lg:table-cell">Date</th>
            <th class="px-2 py-2 text-center">Total Price</th>
            <th class="px-2 py-2 text-center">Number of Tickets</th>
            <th class="px-2 py-2 text-center">Receipt</th>
            @if($showPayment)
                <th class="px-2 py-2 text-center">Payment Type</th>
                <th class="px-2 py-2 text-center">Payment Reference</th>                
            @endif
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
        @foreach ($purchases as $purchase)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                @if($showCustomer)
                    @if (empty($purchase->customer) || empty($purchase->customer->user) )
                    <td class="px-2 py-2 text-center">Unknown</td>
                    @else
                        <td class="px-2 py-2 text-center">{{$purchase->customer->user->name}}</td>
                    @endif
                @endif
                <td class="px-2 py-2 text-left">{{ $purchase->date }}</td>
                <td class="px-2 py-2 text-center">{{ $purchase->total_price }}</td>
                <td class="px-2 py-2 text-center">{{ $purchase->tickets->count() }}</td>
                <td>
                    @if( !empty($purchase->receipt_pdf_filename))
                    <x-table.icon-show class="ps-3 px-0.5 "
                        href="{{ route('receipt.pdf', ['file' => $purchase->receipt_pdf_filename]) }}"/>
                    @else
                    <p class="px-2 text-left">Unavailable</p>
                    @endif
                </td>
                @if($showPayment)
                <td class="px-2 py-2 text-center">{{ $purchase->payment_type}}</td>
                <td class="px-2 py-2 text-center">{{ $purchase->payment_ref}}</td>
                @endif
                @if($showView)
                    {{-- @can('view', $purchase) --}}
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                href="{{ route('purchases.show', ['purchase' => $purchase]) }}"/>
                        </td>
                    {{-- @else --}}
                        <td></td>
                    {{-- @endcan --}}
                @endif
                @if($showEdit)
                    {{-- @can('update', $purchase) --}}
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                href="{{ route('purchases.edit', ['purchase' => $purchase]) }}"/>
                        </td>
                    {{-- @else --}}
                        <td></td>
                    {{-- @endcan --}}
                @endif
                @if($showDelete)
                    {{-- @can('delete', $purchase) --}}
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                action="{{ route('purchases.destroy', ['purchase' => $purchase]) }}"/>
                        </td>
                    {{-- @else --}}
                        <td></td>
                    {{-- @endcan --}}
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
