<?php

namespace App\View\Components\Widget;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Slider extends Component
{
    protected array $slider;
    public function __construct($slider)
    {
        $this->slider = $slider;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.slider',[
            'slider' => $this->slider
        ]);
    }
}
