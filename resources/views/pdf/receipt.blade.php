<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="border-b border-gray-200 pb-6 mb-6">
            <h1 class="text-3xl font-bold text-center mb-4">Purchase Receipt</h1>
            <div class="space-y-2">
                <p class="text-lg"><span class="font-semibold">Purchase Number:</span> {{ $purchase->id }}</p>
                <p class="text-lg"><span class="font-semibold">Date:</span> {{ $purchase->date }}</p>
                <p class="text-lg"><span class="font-semibold">Customer Name:</span> {{ $purchase->customer_name }}</p>
                <p class="text-lg"><span class="font-semibold">Email:</span> {{ $purchase->customer_email }}</p>
                <p class="text-lg"><span class="font-semibold">Total Price:</span> {{ $purchase->total_price }}</p>
                <p class="text-lg"><span class="font-semibold">Payment Type:</span> {{ $purchase->payment_type }}</p>
                <p class="text-lg"><span class="font-semibold">Payment Reference:</span> {{ $purchase->payment_ref }}</p>
            </div>
            @if (isset($purchase?->customer?->user?->photoFullUrl))
            <div class="max-w-xs max-h-xs mt-6">
                <x-field.image
                    name="photo_file"
                    label="Photo"
                    width="1/5"
                    :readonly="true"
                    :deleteAllow="false"
                    :imageUrl="$purchase?->customer?->user?->photoFullUrl" />
            </div>
            @endif
        </div>
        <h2 class="text-2xl font-semibold mb-4">Tickets</h2>
        <ul class="space-y-4">
            @foreach ($tickets as $ticket)
            <li class="border border-gray-200 p-4 rounded-md bg-gray-50">
                <div class="space-y-1">
                    <p><span class="font-semibold">Ticket ID:</span> {{ $ticket->id }}</p>
                    <p><span class="font-semibold">Theater:</span> {{ $ticket->screening->theater->name }}</p>
                    <p><span class="font-semibold">Movie:</span> {{ $ticket->screening->movie->title }}</p>
                    <p><span class="font-semibold">Date & Time:</span> {{ $ticket->screening->date . ' ' . $ticket->screening->start_time }}</p>
                    <p><span class="font-semibold">Seat:</span> {{ $ticket->seat->row . '' . $ticket->seat->seat_number }}</p>
                </div>
                <div class="mt-2 flex justify-center">
                    <img class="w-24 h-24" src="{{'data:image/png;base64,'.base64_encode(QrCode::format('png')->size(100)->generate( route('ticket.pdf', ['file' => $ticket->qrcode_url])))}}" alt="QR Code">
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</body>

</html>
