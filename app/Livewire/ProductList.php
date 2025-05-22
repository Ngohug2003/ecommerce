<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $cart = [];

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        if (!$product->isInStock($quantity)) {
            session()->flash('error', 'Sản phẩm không đủ tồn kho!');
            return;
        }

        $currentQuantity = isset($this->cart[$productId]) ? $this->cart[$productId]['quantity'] : 0;
        $newQuantity = $currentQuantity + $quantity;

        if (!$product->isInStock($newQuantity)) {
            session()->flash('error', 'Số lượng vượt quá tồn kho!');
            return;
        }

        $this->cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $newQuantity,
            'image' => $product->image,
        ];

        session()->put('cart', $this->cart);
        session()->flash('success', 'Đã thêm sản phẩm vào giỏ hàng!');

        // Phát sự kiện để cập nhật số lượng giỏ hàng
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $products = Product::active()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate(12);

        return view('livewire.client.product-list', compact('products'));
    }
}
