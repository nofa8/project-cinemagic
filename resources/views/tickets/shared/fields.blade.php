<div class="container mx-auto mt-5">
    <div class="max-w-xl mx-auto bg-white p-5 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-5">Ticket Details</h1>
        
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket ID: {{ $ticket->id }}</h2>
        </div>
        @if( !empty($ticket->purchase?->customer_name))
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Costumer Name: {{ $ticket->purchase->customer_name}} </h2>
        </div>
        @endif
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket Price: {{ $ticket->price }}€</h2>
        </div>
        @if( !empty($ticket?->screening?->theater?->name))
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket Theater: {{ $ticket->screening->theater->name }}</h2>
        </div>
        @endif
        @if( !empty($ticket?->screening?->movie?->title))
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket Movie: {{ $ticket->screening->movie->title }}</h2>
        </div>
        @endif
        @if( !empty($ticket?->screening))
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Ticket Screening Date: {{ $ticket->screening->date }} {{$ticket->screening->start_time}}</h2>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold"> Screening ID: {{ $ticket->screening->id }} </h2>
        </div>
        @endif
    </div>
</div>