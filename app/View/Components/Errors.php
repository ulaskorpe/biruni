<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ViewErrorBag;

class Errors extends Component
{
    protected ViewErrorBag $errors;
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.errors',[
            'errors' => $this->errors
        ]);
    }
}
