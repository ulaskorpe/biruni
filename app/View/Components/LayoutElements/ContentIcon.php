<?php

namespace App\View\Components\LayoutElements;

use Closure;
use App\Models\Content;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ContentIcon extends Component
{
    protected string $icon;
    protected array $element;
    public function __construct($icon = "",$element)
    {
        $this->icon = $icon;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.content-icon',[
            'icon' => $this->icon,
            'element' => $this->element,
        ]);
    }
}