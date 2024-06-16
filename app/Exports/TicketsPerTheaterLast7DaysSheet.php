<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TicketsPerTheaterLast7DaysSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Ticket::join('purchases', 'purchases.id', '=', 'tickets.purchase_id')
            ->join('seats', 'tickets.seat_id', '=', 'seats.id')
            ->join('theaters', 'seats.theater_id', '=', 'theaters.id')
            ->select('theaters.name as theater_name', DB::raw('count(*) as total_tickets'))
            ->whereBetween('purchases.date', [now()->subDays(7), now()])
            ->groupBy('theaters.name')
            ->get()
            ->map(function ($item) {
                return ['theater_name' => $item->theater_name, 'total_tickets' => $item->total_tickets];
            });
    }

    public function headings(): array
    {
        return [
            'Theater Name',
            'Total Tickets',
        ];
    }

    public function title(): string
    {
        return 'TicketsPerTheaterLast7Days';
    }
}
