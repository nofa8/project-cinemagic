<?php

namespace App\View\Components\Screenings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class Table extends Component
{
    public $table = [];

    private function getTable(Collection $screenings)
    {
        $table = [];
        $theaters = $screenings->sortBy('theater_id')->pluck('theater_id')->unique();
        $now = now();  // Current date and time

        foreach ($theaters as $theater) {

            $dates = $screenings->where('theater_id', $theater)
            ->filter(function($screening) {
                // Check if the date is today and the start time is in the future
                if (Carbon::parse($screening->date)> now()->addDays(14)){
                    return false;
                }
                elseif (Carbon::parse($screening->date)>now()){
                    return true;
                }
                elseif (Carbon::parse($screening->date)->isToday()) {
                    return Carbon::parse($screening->start_time)->gt(now()->format('H:i:s'));
                }
                return false;                
            })
            ->sortBy('date')->pluck('date')->unique();
            $dateScreenings = [];
            foreach ($dates as $date) {
                $dateScreenings[$date] = $screenings
                    ->where('theater_id', $theater)
                    ->where('date', $date)
                    ->filter(function ($screening) use ($date, $now) {
                        // Convert date string to Carbon instance
                        $screeningDate = Carbon::parse($screening->date);

                        // If the date is today, only include screenings that haven't happened yet
                        if ($screeningDate->isSameDay($now)) {
                            return Carbon::parse($screening->start_time) > $now;
                        }
                        // Otherwise, include all screenings
                        return true;
                    })
                    ->sortBy('start_time')
                    ->values();
            }
            if ( !empty($dateScreenings) ){
                $table[$theater] = $dateScreenings;
            }
            
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
