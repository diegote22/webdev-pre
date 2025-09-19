<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Whether to render the public navbar instead of the authenticated one.
     */
    public bool $publicNav;

    /**
     * Whether page content should be full-bleed (no container paddings).
     */
    public bool $fullBleed;

    /**
     * Create the component instance.
     */
    public function __construct(bool $publicNav = false, bool $fullBleed = false)
    {
        $this->publicNav = $publicNav;
        $this->fullBleed = $fullBleed;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
