<?php

namespace App\View\Components\Courses;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Database\Eloquent\Collection;

class Curriculum extends Component
{
    public $curriculum = [];

    private function getCurriculum(Collection $disciplines)
    {
        $curriculum = [];
        $yearOfCourse = $disciplines->sortBy('year')->pluck('year')->unique();
        foreach ($yearOfCourse as $year) {
            $curriculum[$year] = [];
            // Build $semesters array with 3 elements
            // $semesters[0] - annual disciplines
            // $semesters[1] - disciplines of the first semester
            // $semesters[2] - disciplines of the second semester
            for($semester = 0; $semester <= 2; $semester++) {
                $semesters[$semester] = $disciplines
                    ->sortBy('name')
                    ->where('year', $year)
                    ->where('semester', $semester)
                    ->values();
            }
            // Annual disciplines:
            foreach($semesters[0] as $discipline) {
                $curriculum[$year][] = [
                    [
                        'colspan' => 2,
                        'rowspan' => 0,
                        'discipline' => $discipline
                    ],
                    null
                ];
            }

            // Semester disciplines:
            $totals[1] = $semesters[1]->count();
            $totals[2] = $semesters[2]->count();
            $biggestTotal = max($totals);


            for ($i = 0; $i < $biggestTotal; $i++) {
                $rowSemesters = [];
                for ($semester = 1; $semester <= 2; $semester++) {
                    $discName = $semesters[$semester][$i]->name ?? '';
                    if ($discName != '') {
                        $rowSemesters[$semester] = [
                            'colspan' => 0,
                            'rowspan' => 0,
                            'discipline' => $semesters[$semester][$i]
                        ];
                    } else {
                        // First empty line for this semester
                        if ($i == $totals[$semester]) {
                            $rowspan = 0;
                            // Merge vertically when necessary
                            if ($totals[$semester] + 1 < $biggestTotal) {
                                $rowspan = $biggestTotal - $totals[$semester];
                            }
                            $rowSemesters[$semester] = [
                                'colspan' => 0,
                                'rowspan' => $rowspan,
                                'discipline' => null
                            ];
                        } else {
                            // It is the second, thrid, etc...  empty line
                            $rowSemesters[$semester] = null;
                        }
                    }
                }
                $curriculum[$year][] = $rowSemesters;
            }
        }
        return $curriculum;
    }

    public function __construct(
        public Collection $disciplines,
    )
    {
        $this->curriculum = $this->getCurriculum($disciplines);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.courses.curriculum');
    }
}
