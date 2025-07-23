<?php

namespace App\View\Components;

use Closure;
use App\Models\Content;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use App\Models\ContentPreview;
use Illuminate\Contracts\View\View;

class Column extends Component
{
    protected array $column;
    protected ?bool $tabOrSlideDiv;
    protected Content|ContentCategory|ContentPreview|null $content;
    protected ?bool $isLayout;

    public function __construct($column, $tabOrSlideDiv = false, $content = null, $isLayout = false)
    {
        $this->column = $column;
        $this->tabOrSlideDiv = $tabOrSlideDiv;
        $this->content = $content;
        $this->isLayout = $isLayout;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.column',[
            'column' => $this->column,
            'tabOrSlideDiv' => $this->tabOrSlideDiv,
            'content' => $this->content,
            'isLayout' => $this->isLayout,
        ]);
    }
}
