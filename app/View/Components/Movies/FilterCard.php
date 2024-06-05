<?php

namespace App\View\Components\Movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Genre;
class FilterCard extends Component
{
    
    public array $listGenre;

    public function __construct(
        
        public array $genres,
        public string $filterAction,
        public string $resetUrl,
        public ?string $genre = null,
        
        
        public ?string $title = null,

    )
    {
        $this->listGenre = (array_merge([null => 'Any genre'], Genre::pluck('name', 'code')->toArray()));

        

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.filter-card');
    }
}
