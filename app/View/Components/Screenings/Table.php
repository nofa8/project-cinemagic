<?php

namespace App\View\Components\Screenings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Database\Eloquent\Collection;

class Table extends Component
{
    public $table = [];

    private function getTable(Collection $screenings)
    {
        $table = [];
        $theaters = $screenings->sortBy('theater_id')->pluck('theater_id')->unique();
        
        foreach ($theaters as $theater) {
            $dates = $screenings->where('theater_id', $theater)
            ->whereBetween('date', [now(), now()->addDays(14)])
            ->sortBy('date')->pluck('date')->unique();
            $dateScreenings = [];
            
            foreach ($dates as $date) {
                $dateScreenings[$date] = $screenings
                    ->where('theater_id', $theater)
                    ->where('date', $date)
                    ->sortBy('start_time')
                    ->values();
            }
            
            $table[$theater] = $dateScreenings;
        }
        
        return $table;
    }


    public function __construct(
        public Collection $screenings,
    )
    {
        $this->table = $this->getTable($screenings);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.screenings.table');
    }
}
