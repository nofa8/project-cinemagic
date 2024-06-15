<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
</head>

<body>
    <h1>Purchase Receipt</h1>
    <p>Purchase Number: {{ $purchase->id }}</p>
    <p>Date: {{ $purchase->date }}</p>
    <p>Customer Name: {{ $purchase->customer_name }}</p>
    <p>Email: {{ $purchase->customer_email }}</p>
    <p>Total Price: {{ $purchase->total_price }}</p>
    <p>Payment Type: {{ $purchase->payment_type }}</p>
    <p>Payment Reference: {{ $purchase->payment_ref }}</p>
    @if (isset($purchase?->customer?->user?->photoFullUrl))
        <img class="w-sm h-sm" src="$purchase?->customer?->user?->photoFullUrl" alt="Photo">
     />
    @endif
    <h2>Tickets</h2>
    <ul>
        @foreach ($tickets as $ticket)
            <li>
                Ticket ID: {{ $ticket->id }}<br>
                Theater: {{ $ticket->screening->theater->name }}<br>
                Movie: {{ $ticket->screening->movie->title }}<br>
                Date & Time: {{ $ticket->screening->date . ' ' . $ticket->screening->start_time }}<br>
                Seat: {{ $ticket->seat->row . '' . $ticket->seat->seat_number }}<br>
                <img src="{{'data:image/png;base64,'.base64_encode(QrCode::format('png')->size(100)->generate( route('ticket.pdf', ['file' => $ticket->qrcode_url])))}}" alt="QR Code">
            </li>
        @endforeach

    </ul>
</body>

</html>
