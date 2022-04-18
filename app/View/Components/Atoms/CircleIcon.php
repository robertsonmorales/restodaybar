<?php

namespace App\View\Components\Atoms;

use Illuminate\View\Component;

class CircleIcon extends Component
{
    public $value, $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $value, string $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.atoms.circle-icon');
    }
}
