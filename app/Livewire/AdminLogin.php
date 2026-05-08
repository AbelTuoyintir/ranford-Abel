<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminLogin extends Component
{
    // #[Rule('required|string')]
 

    // #[Rule('required|string')]
    


    

    public function login()
    {
        
        dump('HELLO WORLD');    
        // $validated = $this->validate();

        // if (Auth::guard('admin')->attempt($validated)) {
        //     return $this->redirect(route('admin.dashboard'));
        // }

      
        // $this->reset('password');
    }

    // #[Layout('components.layouts.app')]
    
    public function render()
    {
        return view('livewire.admin-login');
    }
}
