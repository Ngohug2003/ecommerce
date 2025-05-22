<?php
// app/Livewire/CartCounter.php
namespace App\Livewire;

use Livewire\Component;

class CartCounter extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->cartCount = count(session()->get('cart', []));
    }

    public function updateCartCount()
    {
        $this->cartCount = count(session()->get('cart', []));
    }

    public function render()
    {
        return view('livewire.client.cart-counter');
    }
}
