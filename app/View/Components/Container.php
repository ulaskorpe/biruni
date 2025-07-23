<?php

namespace App\View\Components;

use Closure;
use App\Models\Content;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use App\Models\ContentPreview;
use Illuminate\Contracts\View\View;

class Container extends Component
{
    protected array $container;
    protected ?bool $tabOrSlideDiv;
    protected Content|ContentCategory|ContentPreview|null $content;
    protected ?bool $isLayout;

    public function __construct($container,$tabOrSlideDiv = false, $content = null, $isLayout = false)
    {
        $this->container = $container;
        $this->tabOrSlideDiv = $tabOrSlideDiv;
        $this->content = $content;
        $this->isLayout = $isLayout;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.container',[
            'container' => $this->container,
            'tabOrSlideDiv' => $this->tabOrSlideDiv,
            'content' => $this->content,
            'isLayout' => $this->isLayout,
        ]);
    }
}
