<?php

namespace App\View\Components\Cards;

use App\Models\ContentCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentCardCategory extends Component
{
    protected ContentCategory $category;
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.content-category-card',[
            'category' => $this->category
        ]);
    }
}
