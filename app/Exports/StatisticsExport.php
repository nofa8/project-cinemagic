<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StatisticsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SummarySheet(),
            new TicketsPerTheaterLast30DaysSheet(),
            new MoviesPerGenreLast30DaysSheet(),
            new MoviesPerGenreLast7DaysSheet(),
            new TicketsPerTheaterLast7DaysSheet(),
            new MoviesPerGenreLastDaySheet(),
            new TicketsPerTheaterLastDaySheet()
        ];
    }
}
