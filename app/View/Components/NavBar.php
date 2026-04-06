<?php

namespace App\View\Components;

use App\Services\ModuleTreeService;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class NavBar extends Component
{
    public Collection $modules;

    public function __construct(ModuleTreeService $moduleTreeService)
    {
        $this->modules = collect();

        if (auth()->check()) {
            $this->modules = $moduleTreeService->getTreeForUser(auth()->user());
        }
    }

    public function render()
    {
        return view('components.nav-bar');
    }
}

