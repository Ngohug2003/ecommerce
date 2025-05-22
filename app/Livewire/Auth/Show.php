<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        $user = Auth::user();
        return view('livewire.auth.show', compact('user'));
    }
}
