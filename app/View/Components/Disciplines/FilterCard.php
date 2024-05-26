<?php

namespace App\View\Components\Disciplines;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listCourses;
    public array $listYears;
    public array $listSemesters;

    public function __construct(
        public array $courses,
        public string $filterAction,
        public string $resetUrl,
        public ?string $course = null,
        public ?int $year = null,
        public ?int $semester = null,
        public ?string $teacher = null,
    )
    {
        $this->listCourses = (array_merge([null => 'Any course'], $courses));
        $this->listYears = [
            null => 'Any year',
            1 => '1st year',
            2 => '2nd year',
            3 => '3rd year'
        ];
        $this->listSemesters = [
            null => 'Any semester',
            1 => '1st semester',
            2 => '2nd semester',
            0 => 'Annual'
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.disciplines.filter-card');
    }
}
