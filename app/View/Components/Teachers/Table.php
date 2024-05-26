<?php

namespace App\View\Components\Teachers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public object $teachers,
        public bool $showDepartment = true,
        public bool $showView = true,
        public bool $showEdit = true,
        public bool $showDelete = true,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.teachers.table');
    }
}
