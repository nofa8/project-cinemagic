<?php

namespace App\View\Components\Movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    
    public array $listGenre;

    public function __construct(
        
        public array $genres,
        public string $filterAction,
        public string $resetUrl,
        public ?int $genre = null,
        
        
        public ?string $title = null,

    )
    {
        $this->listGenre = [
            null => 'Any Genre',
            1 => 'Action',
            2 => 'Adventure',
            3 => 'Animation',
            4 => 'Bibliography',
            5=> 'Comedy',
            6=> 'Comedy and Action',
            7=> 'Romantic comedy',
            8=> 'Crime',
            9=> 'Cult movie',
            10=> 'Drama',
            11=> 'Family',
            12=> 'Fantasy',
            13=> 'Historical',
            14=> 'Horror',
            15=> 'Mystery',
            16=> 'Musical',
            17=> 'Romance',
            18=> 'Science fiction',
            19=> 'Silent Movie',
            20=> 'Super heroes',
            21=> 'Suspense',
            22=> 'Thriller',
            23=> 'War',
            24=> 'Western',
        ];

        

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.filter-card');
    }
}
