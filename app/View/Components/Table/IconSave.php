<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class IconSave extends Component
{
    public $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function render()
    {
        return view('components.table.icon-save');
    }
}
