<?php

namespace App\View\Components\Widget;

use Closure;
use App\Models\Content;
use App\Models\ContentPreview;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use Illuminate\Contracts\View\View;

class DesignTemplate extends Component
{
    protected array $data;
    protected Content|ContentCategory|ContentPreview|null $content;

    public function __construct($data, $content = null)
    {
        $this->data = $data;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.design-template',[
            'data' => $this->data,
            'content' => $this->content,
        ]);
    }
}
