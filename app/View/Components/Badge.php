<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Badge extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $type;
    public $message;
    public $show;

    public function __construct(string $type, string $message, bool $show)
    {
        $this->type = $type;
        $this->message = $message;
        $this->show = $show;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() : View
    {
        return view('components.badge');
    }
}
