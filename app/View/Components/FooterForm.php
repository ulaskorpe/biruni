<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterForm extends Component
{
    protected ?int $formid;

    public function __construct($formid = null)
    {
        $this->formid = $formid;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer-form',[
            'formid' => $this->formid
        ]);
    }
}
