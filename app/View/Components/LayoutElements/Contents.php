<?php

namespace App\View\Components\LayoutElements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Contents extends Component
{
    protected array $contents;
    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.contents',[
            'contents' => $this->contents
        ]);
    }
}
