<?php

namespace App\View\Components;

use Closure;
use App\Models\Form;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class KvkkCheck extends Component
{
    protected ?Form $form;
    public function __construct($form = null)
    {
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kvkk-check',[
            'form' => $this->form
        ]);
    }
}
