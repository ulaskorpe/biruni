<?php

namespace App\View\Components;

use App\Models\Form;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormComponent extends Component
{
    protected Form $form;
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-component',[
            'form' => $this->form
        ]);
    }
}
