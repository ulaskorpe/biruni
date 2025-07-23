<?php

namespace App\View\Components\LayoutElements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Summary extends Component
{
    protected ?string $summary;
    protected array $element;
    public function __construct($summary = "",$element)
    {
        $this->summary = $summary;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.summary',[
            'summary' => $this->summary,
            'element' => $this->element,
        ]);
    }
}
