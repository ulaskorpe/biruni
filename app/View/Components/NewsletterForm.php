<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsletterForm extends Component
{
    protected ?array $data;
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.newsletter-form',[
            'data' => $this->data
        ]);
    }
}
