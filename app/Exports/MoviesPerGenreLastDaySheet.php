<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MoviesPerGenreLastDaySheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Movie::join('genres', 'movies.genre_code', '=', 'genres.code')
            ->join('screenings', 'screenings.movie_id', '=', 'movies.id')
            ->select('genres.name as genre_name', DB::raw('count(*) as total_movies'))
            ->whereBetween('screenings.date', [now()->subDays(1), now()])
            ->groupBy('genres.name')
            ->get()
            ->map(function ($item) {
                return ['genre_name' => $item->genre_name, 'total_movies' => $item->total_movies];
            });
    }

    public function headings(): array
    {
        return [
            'Genre Name',
            'Total Movies',
        ];
    }
    public function title(): string
    {
        return 'MoviesPerGenreLastDay';
    }
}
