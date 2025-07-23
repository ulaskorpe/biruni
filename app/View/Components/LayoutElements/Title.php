<?php

namespace App\View\Components\LayoutElements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Title extends Component
{
    protected string $title;
    protected array $element;
    public function __construct($title,$element)
    {
        $this->title = $title;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.title',[
            'title' => $this->title,
            'element' => $this->element,
        ]);
    }
}
