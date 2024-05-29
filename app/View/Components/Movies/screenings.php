<?php

namespace App\View\Components\Movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Database\Eloquent\Collection;

class Screenings extends Component
{
    public $screenings = [];

    private function getScreenings(Collection $screenings)
    {
        $screenings = [];
        
        return $screenings;
    }

    public function __construct(
        public Collection $Screenings,
    )
    {
        $this->screening = $this->getScreenings($Screenings);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.screenings');
    }
}
