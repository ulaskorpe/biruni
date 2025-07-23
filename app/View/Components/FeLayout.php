<?php

namespace App\View\Components;

use App\Models\Content;
use App\Models\HeaderLayout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Illuminate\View\Component;

class FeLayout extends Component
{
    protected ?Content $content;
    protected ?Collection $connecteds;
    protected ?HeaderLayout $headerLayout;
    protected ?array $breadCrumb;
    protected ?bool $isHome;
    public function __construct($content = null, $connecteds = null, $headerLayout = null, $breadCrumb = null, $isHome = false)
    {
        $this->content = $content;
        $this->connecteds = $connecteds;
        $this->headerLayout = $headerLayout;
        $this->breadCrumb = $breadCrumb;
        $this->isHome = $isHome;
    }

    public function render(): View
    {
        return view('fe',[
            'content' => $this->content,
            'connecteds' => $this->connecteds,
            'headerLayout' => $this->headerLayout,
            'breadCrumb' => $this->breadCrumb,
            'isHome' => $this->isHome
        ]);
    }
}
