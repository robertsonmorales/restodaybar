<?php

namespace App\View\Components\Molecules;

use Illuminate\View\Component;

class TableFilter extends Component
{
    public $pagesize, $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $pagesize, $route)
    {
        $this->pagesize = $pagesize;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.molecules.table-filter');
    }
}
