<?php

namespace App\Livewire\Auth;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password;

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->route('products.index')->with('success', 'Đăng nhập thành công!');
        }

        $this->addError('email', 'Thông tin đăng nhập không chính xác.');
    }
  

    public function render()
    {
        return view('livewire.auth.login');
    }
}