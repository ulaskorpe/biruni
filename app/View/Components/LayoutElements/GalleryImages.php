<?php

namespace App\View\Components\LayoutElements;

use Closure;
use App\Models\Media;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class GalleryImages extends Component
{
    protected ?Collection $galleryImages;
    protected array $element;
    protected ?string $alt;
    public function __construct($galleryImages = null,$element)
    {
        $this->galleryImages = $galleryImages;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.gallery-images',[
            'galleryImages' => $this->galleryImages,
            'element' => $this->element,
        ]);
    }
}
