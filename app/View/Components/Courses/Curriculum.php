<?php

namespace App\View\Components\Courses;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Curriculum extends Component
{
    public $curriculum = [];

    private function getCurriculum(Collection $screening)
    {
        $curriculum = [];
        $mytime = Carbon::now();
        $mytime->toDateTimeString();
        $theaters = $screening->sortBy('theater_id')->where('date','>=',$mytime)->pluck('theater_id')->unique();
        $dates = $screening->sortBy('date')->where('date','>=',$mytime)->pluck('date')->unique();
        foreach ($theaters as $theater) {
            
            $curriculum[$theater] = [];
            foreach($dates as $date) {
                $dates[$date] = $screening //->sortBy('title')
                    ->where('theater_id', $theater)
                    ->where('date', $date)
                    ->values();
            }
            $totals = [];
            foreach($dates as $date) {
                $totals[] = $date->count();
            }
            $biggestTotal = max($totals);
            foreach($dates as $date) {
                $curriculum[$theater][$date] = $date->count() / $biggestTotal;
            }

        return curriculum;
    }

    public function __construct(
        public Collection $screening,
    )
    {
        $this->curriculum = $this->getCurriculum($screening);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.courses.curriculum');
    }
}
