<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageHeader extends Component
{
    protected ?string $parentTitle;
    protected string $title;
    protected ?string $subTitle;
    protected ?Media $headerImage;
    protected ?Media $headerVideo;
    protected ?array $contentAttributes;
    protected ?array $breadCrumb;

    public function __construct(string $parentTitle = "", string $title = "", string $subTitle = "", $headerImage = null, $headerVideo = null, $contentAttributes = [], $breadCrumb = [])
    {
        $this->parentTitle = $parentTitle;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->headerImage = $headerImage;
        $this->headerVideo = $headerVideo;
        $this->contentAttributes = $contentAttributes;
        $this->breadCrumb = $breadCrumb;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-header',[
            'title' => $this->title,
            'parentTitle' => $this->parentTitle,
            'subTitle' => $this->subTitle,
            'headerImage' => $this->headerImage,
            'headerVideo' => $this->headerVideo,
            'contentAttributes' => $this->contentAttributes,
            'breadCrumb' => $this->breadCrumb
        ]);
    }
}
