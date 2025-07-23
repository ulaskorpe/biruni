<?php

namespace App\View\Components\Widget;

use Closure;
use App\Models\Content;
use App\Models\ContentPreview;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use Illuminate\Contracts\View\View;

class Widget extends Component
{
    protected array $widget;
    protected Content|ContentCategory|ContentPreview|null $content;
    
    public function __construct($widget, $content = null)
    {
        $this->widget = $widget;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.widget',[
            'widget' => $this->widget,
            'content' => $this->content,
        ]);
    }
}
