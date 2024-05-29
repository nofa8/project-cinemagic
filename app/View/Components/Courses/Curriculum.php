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
        $theaters = $screening->sortBy('theater_id')->pluck('theater_id')->unique();
        $dates = $screening->sortBy('date')->pluck('date')->unique();
        $hours = $screening->sortBy('start_time')->pluck('theater_id')->unique();
        @dump($theaters);
        @dump($hours);
        @dump($dates);
        foreach ($theaters as $theaterId => $theaterScreenings) {
            $dates = $theaterScreenings->groupBy('date');

            foreach ($dates as $date => $dateScreenings) {
                $groupedByTime = $dateScreenings->groupBy('start_time');

                foreach ($groupedByTime as $startTime => $timeScreenings) {
                    foreach ($timeScreenings as $screening) {
                        $curriculum[$theaterId][$date][$startTime][] = $screening;
                    }
                }
            }
        }

        return $curriculum;
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
