<?php

namespace App\View\Components\Elements;

use Closure;
use App\Models\Content;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use App\Models\ContentPreview;
use Illuminate\Contracts\View\View;

class Index extends Component
{
    protected array $element;
    protected Content|ContentCategory|ContentPreview|null $content;
    public function __construct($element, $content = null)
    {
        $this->element = $element;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.elements.'.$this->element['blade'],[
            'element' => $this->element,
            'content' => $this->content,
        ]);
    }
}
