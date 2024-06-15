<?php

namespace App\Exports;

use App\Models\Ticket;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatisticsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $data = collect([
            [
                'Total Tickets' => Ticket::count(),
                'Most Expensive Purchase' => Purchase::max('total_price'),
                'Total Revenue' => Purchase::sum('total_price'),
                'Average Purchase Price' => Purchase::avg('total_price'),
            ]
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Total Tickets',
            'Most Expensive Purchase',
            'Total Revenue',
            'Average Purchase Price',
        ];
    }
}
