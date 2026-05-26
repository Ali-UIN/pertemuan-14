<?php

namespace App\View\Components;

use App\Models\Buku;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BukuCard extends Component
{
    public function __construct(
        public Buku $buku,
        public bool $showActions = true
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.buku-card');
    }
}