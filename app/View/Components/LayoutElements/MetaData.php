<?php

namespace App\View\Components\LayoutElements;

use App\Models\Content;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MetaData extends Component
{
    protected Content $content;
    protected array $element;
    public function __construct($content,$element)
    {
        $this->content = $content;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.meta-data',[
            'content' => $this->content,
            'element' => $this->element,
        ]);
    }
}
