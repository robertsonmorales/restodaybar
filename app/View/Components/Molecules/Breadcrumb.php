<?php

namespace App\View\Components\Molecules;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title, $breadcrumbs;

    /**
     * Create a new component instance.
     * 
     * @return void
     */
    public function __construct($title, $breadcrumbs)
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.molecules.breadcrumb');
    }
}
