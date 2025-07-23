<?php

namespace App\View\Components\LayoutElements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Description extends Component
{
    protected ?string $description;
    protected array $element;
    public function __construct($description = "",$element)
    {
        $this->description = $description;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.description',[
            'description' => $this->description,
            'element' => $this->element,
        ]);
    }
}
