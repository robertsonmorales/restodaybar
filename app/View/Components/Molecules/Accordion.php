<?php

namespace App\View\Components\Molecules;

use Illuminate\View\Component;

class Accordion extends Component
{
    public $level, $navigations;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($level, $navigations)
    {
        $this->level = $level;
        $this->navigations = $navigations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.molecules.accordion');
    }
}
