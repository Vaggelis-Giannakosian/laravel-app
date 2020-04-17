<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class Updated extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $type;
    public $date;
    public $name;

    public function __construct(Carbon $date, string $name='', string $type='Added ')
    {
        $this->type = $type;
        $this->date = $date;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.updated');
    }
}
