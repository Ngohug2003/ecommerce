<?php
namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderHistory extends Component
{
    use WithPagination;

    public $selectedOrder = null;

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        Log::info($this->selectedOrder);
    }

    public function closeModal()
    {
        $this->selectedOrder = null;
    }

    public function render()
    {
        $orders = Order::with(['orderItems'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.client.order-history', compact('orders'));
    }
}
