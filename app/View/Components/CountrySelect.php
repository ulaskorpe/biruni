<?php

namespace App\View\Components;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CountrySelect extends Component
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
        return view('components.country-select',[
            'guid' => $this->guid
        ]);
    }
}
