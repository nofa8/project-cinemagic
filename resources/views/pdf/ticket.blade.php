<!DOCTYPE html>
<html>
<head>
    <title>Ticket</title>
</head>
<body>
    <h1>Tickets</h1>
    <ul>
        <li>
            Ticket ID: {{ $ticket->id }}<br>
            Theater: {{ $ticket->screening->theater->name }}<br>
            Movie: {{ $ticket->screening->movie->title }}<br>
            Date & Time: {{ $ticket->screening->date ." ".$ticket->screening->start_time }}<br>
            Seat: {{ $ticket->seat->row."".$ticket->seat->seat_number }}
            
        </li>
    </ul>
</body>
</html>
