<?php

namespace App\View\Components\Cards;

use Closure;
use App\Models\Content;
use App\Models\CardLayout;
use App\Models\ContentPreview;
use Illuminate\View\Component;
use App\Models\ContentCategory;
use Illuminate\Contracts\View\View;

class DynamicCard extends Component
{
    protected Content|ContentCategory|ContentPreview $content;
    protected CardLayout $cardLayout;
    protected ?bool $useDate;
    protected ?bool $useMeta;
    public function __construct($content,$cardLayout,$useDate = false,$useMeta = false)
    {
        $this->content = $content;
        $this->cardLayout = $cardLayout;
        $this->useDate = $useDate;
        $this->useMeta = $useMeta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.dynamic-card',[
            'content' => $this->content,
            'cardLayout' => $this->cardLayout,
            'useDate' => $this->useDate,
            'useMeta' => $this->useMeta,
        ]);
    }
}
