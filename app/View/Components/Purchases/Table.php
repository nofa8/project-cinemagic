<?php

namespace App\View\Components\Purchases;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public object $purchases,
        public bool $showView = true,
        public bool $showEdit = true,
        public bool $showDelete = true,
        public bool $showPayment = false,
        public bool $showCustomer = false
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.purchases.table');
    }
}
