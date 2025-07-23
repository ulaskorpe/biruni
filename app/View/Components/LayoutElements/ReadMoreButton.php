<?php

namespace App\View\Components\LayoutElements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReadMoreButton extends Component
{
    protected string $uri;
    protected array $element;
    protected ?array $contentAttributes;
    public function __construct($uri,$element,$contentAttributes = null)
    {
        $this->uri = $uri;
        $this->element = $element;
        $this->contentAttributes = $contentAttributes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.read-more-button',[
            'uri' => $this->uri,
            'element' => $this->element,
            'contentAttributes' => $this->contentAttributes,
        ]);
    }
}
