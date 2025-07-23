<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    protected array $data;
    protected string $title;
    public function __construct(array $data,$title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb',[
            'data' => $this->data,
            'title' => $this->title,
        ]);
    }
}
