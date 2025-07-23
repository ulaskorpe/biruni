<?php

namespace App\View\Components\LayoutElements;

use Closure;
use App\Models\Media;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class DependingContents extends Component
{
    protected ?Collection $dependingContents;
    protected array $element;
    public function __construct($dependingContents = null,$element)
    {
        $this->dependingContents = $dependingContents;
        $this->element = $element;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout-elements.depending-contents',[
            'dependingContents' => $this->dependingContents,
            'element' => $this->element,
        ]);
    }
}
