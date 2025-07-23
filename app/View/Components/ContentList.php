<?php

namespace App\View\Components;

use App\Models\CardLayout;
use App\Models\ContentCategory;
use App\Models\ContentType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentList extends Component
{
    protected ?ContentCategory $category;
    protected ?ContentType $contentType;
    protected ?CardLayout $cardLayout;
    protected ?bool $useDate;
    protected ?bool $useMeta;
    protected int $columnCount;
    
    public function __construct($category = null, $contentType = null, $cardLayout = null, $columnCount = 3,$useDate = false,$useMeta = false)
    {
        $this->contentType = $contentType;
        $this->category = $category;
        $this->cardLayout = $cardLayout;
        $this->columnCount = $columnCount;
        $this->useDate = $useDate;
        $this->useMeta = $useMeta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content-list', [
            'contentType' => $this->contentType,
            'category' => $this->category,
            'cardLayout' => $this->cardLayout,
            'columnCount' => $this->columnCount,
            'useDate' => $this->useDate,
            'useMeta' => $this->useMeta,
        ]);
    }
}
