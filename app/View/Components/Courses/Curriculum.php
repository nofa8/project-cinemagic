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
        return view('components.movies.curriculum');
    }
}
