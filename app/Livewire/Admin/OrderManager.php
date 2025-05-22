<?php
namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManager extends Component
{
    use WithPagination;

    public $selectedOrder = null;
    public $statusFilter = '';

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::withDetails()->findOrFail($orderId);
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        
        session()->flash('success', 'Cập nhật trạng thái đơn hàng thành công!');
        
        if ($this->selectedOrder && $this->selectedOrder->id == $orderId) {
            $this->selectedOrder->status = $status;
        }
    }

    public function closeModal()
    {
        $this->selectedOrder = null;
    }

    public function render()
    {
        $orders = Order::withDetails()
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.order-manager', compact('orders'));
    }
}