<?php

namespace App\View\Components\LayoutElements;

use Closure;
use App\Models\Content;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ContentAttributes extends Component
{
    protected array $contentAttributes;
    protected array $element;
    protected ?string $contentName;
    public function __construct($contentAttributes = [],$element, $contentName = "")
    {
        $this->contentAttributes = $contentAttributes;
        $this->element = $element;
        $this->contentName = $contentName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.content-attributes',[
            'contentAttributes' => $this->contentAttributes,
            'element' => $this->element,
            'contentName' => $this->contentName
        ]);
    }
}