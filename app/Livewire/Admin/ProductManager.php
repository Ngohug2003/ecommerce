<?php
namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $editingProduct = null;
    
    public $name = '';
    public $description = '';
    public $price = '';
    public $stock_quantity = '';
    public $image;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|max:1024',
        'is_active' => 'boolean',
    ];

    public function create()
    {
        $this->reset(['name', 'description', 'price', 'stock_quantity', 'image', 'is_active']);
        $this->editingProduct = null;
        $this->showModal = true;
    }

    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        $this->editingProduct = $product;
        
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock_quantity = $product->stock_quantity;
        $this->is_active = $product->is_active;
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('products', 'public');
        }

        if ($this->editingProduct) {
            $this->editingProduct->update($data);
            session()->flash('success', 'Cập nhật sản phẩm thành công!');
        } else {
            Product::create($data);
            session()->flash('success', 'Tạo sản phẩm thành công!');
        }

        $this->closeModal();
    }

    public function delete($productId)
    {
        Product::findOrFail($productId)->delete();
        session()->flash('success', 'Xóa sản phẩm thành công!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'description', 'price', 'stock_quantity', 'image', 'is_active']);
        $this->editingProduct = null;
    }

    public function render()
    {
        $products = Product::latest()->paginate(10);
        return view('livewire.admin.product-manager', compact('products'));
    }
}