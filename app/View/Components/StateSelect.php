<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StateSelect extends Component
{
    protected string $guid;

    public function __construct($guid)
    {
        $this->guid = $guid;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.state-select',[
            'guid' => $this->guid
        ]);
    }
}
