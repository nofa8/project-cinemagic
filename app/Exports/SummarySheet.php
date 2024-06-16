<?php
namespace App\Exports;

use App\Models\Ticket;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummarySheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return collect([
            [
                'Metric' => 'Total Tickets',
                'Value' => Ticket::count(),
            ],
            [
                'Metric' => 'Most Expensive Purchase',
                'Value' => Purchase::max('total_price'),
            ],
            [
                'Metric' => 'Total Revenue',
                'Value' => Purchase::sum('total_price'),
            ],
            [
                'Metric' => 'Average Purchase Price',
                'Value' => Purchase::avg('total_price'),
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Metric',
            'Value',
        ];
    }

    public function title(): string
    {
        return 'SummarySheet';
    }
}
