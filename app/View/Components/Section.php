<?php

namespace App\View\Components;

use Closure;
use App\Models\Content;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use App\Models\ContentPreview;
use Illuminate\Contracts\View\View;

class Section extends Component
{
    protected array $section;
    protected ?bool $tabOrSlideDiv;
    protected Content|ContentCategory|ContentPreview|null $content;
    protected ?bool $isLayout;

    public function __construct($section,$tabOrSlideDiv = false, $content = null, $isLayout = false)
    {
        $this->section = $section;
        $this->tabOrSlideDiv = $tabOrSlideDiv;
        $this->content = $content;
        $this->isLayout = $isLayout;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section',[
            'section' => $this->section,
            'tabOrSlideDiv' => $this->tabOrSlideDiv,
            'content' => $this->content,
            'isLayout' => $this->isLayout,
        ]);
    }
}
