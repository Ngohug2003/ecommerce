<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Component
{
    public $cart = [];
    public $notes = '';

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }
    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        session()->put('cart', $this->cart);
        session()->flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        $product = Product::findOrFail($productId);

        if (!$product->isInStock($quantity)) {
            session()->flash('error', 'Số lượng vượt quá tồn kho!');
            return;
        }

        $this->cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $this->cart);
    }



    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Giỏ hàng trống!');
            return;
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            DB::beginTransaction();

            // Validate stock trước khi tạo order
            foreach ($this->cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                if (!$product->isInStock($item['quantity'])) {
                    throw new \Exception("Sản phẩm {$product->name} không đủ tồn kho!");
                }
            }

            // Tạo order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'notes' => $this->notes,
            ]);

            // Tạo order items và giảm stock
            foreach ($this->cart as $productId => $item) {
                $product = Product::findOrFail($productId);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product->reduceStock($item['quantity']);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');
            $this->cart = [];

            session()->flash('success', 'Đặt hàng thành công!');
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    public function getTotal()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.client.cart');
    }
}
