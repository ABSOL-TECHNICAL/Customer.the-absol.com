<?php

namespace App\View\Components\Filament\Forms\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomFileUpload extends Component
{

    protected $accept;
    /**
     * Create a new component instance.
     */
    public function __construct($accept = null)
    {
        //
        $this->accept = $accept;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filament.forms.components.custom-file-upload',[
            'accept' => $this->accept,
        ]);
    }
    

}
