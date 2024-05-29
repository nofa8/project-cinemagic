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

    private function getCurriculum(Collection $screenings)
    {
        $curriculum = [];
        $currentTime = Carbon::now();

        // Filter screenings for future dates
        $futureScreenings = $screenings->filter(function ($screening) use ($currentTime) {
            return Carbon::parse($screening->date)->gte($currentTime);
        });

        // Group by theater, then by date, and then by start time
        $groupedByTheater = $futureScreenings->groupBy('theater_id');

        foreach ($groupedByTheater as $theaterId => $theaterScreenings) {
            $groupedByDate = $theaterScreenings->groupBy('date');

            foreach ($groupedByDate as $date => $dateScreenings) {
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
