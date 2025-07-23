<?php

namespace App\View\Components\Widget;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Contents extends Component
{
    protected array $widget;
    public function __construct($widget)
    {
        $this->widget = $widget;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.contents',[
            'widget' => $this->widget
        ]);
    }
}
