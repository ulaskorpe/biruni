<?php

namespace App\View\Components\LayoutElements;

use Closure;
use App\Models\Media;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MainImage extends Component
{
    protected ?Media $media;
    protected array $element;
    protected ?string $alt;
    protected ?array $contentAttributes;
    public function __construct($media = null,$element,$alt = "",$contentAttributes = [])
    {
        $this->media = $media;
        $this->element = $element;
        $this->alt = $alt;
        $this->contentAttributes = $contentAttributes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.main-image',[
            'media' => $this->media,
            'element' => $this->element,
            'alt' => $this->alt,
            'contentAttributes' => $this->contentAttributes,
        ]);
    }
}
