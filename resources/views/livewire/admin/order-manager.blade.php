<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📦 Quản lý đơn hàng</h1>
        
        <select wire:model.live="statusFilter" class="mt-3 md:mt-0 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            <option value="">Tất cả trạng thái</option>
            <option value="pending">🕓 Chờ xử lý</option>
            <option value="processing">⚙️ Đang xử lý</option>
            <option value="shipped">🚚 Đã gửi</option>
            <option value="delivered">✅ Đã giao</option>
            <option value="cancelled">❌ Đã hủy</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <table class="min-w-full table-auto divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">Mã ĐH</th>
                    <th class="px-6 py-3 text-left">Khách hàng</th>
                    <th class="px-6 py-3 text-left">Tổng tiền</th>
                    <th class="px-6 py-3 text-left">Trạng thái</th>
                    <th class="px-6 py-3 text-left">Ngày tạo</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-800">#{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 text-blue-600 font-semibold">
                            {{ number_format($order->total_amount, 0, ',', '.') }}đ
                        </td>
                        <td class="px-6 py-4">
                            <select 
                                wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                class="border-gray-300 text-sm rounded-md bg-white shadow-sm"
                            >
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🕓 Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="viewOrder({{ $order->id }})"
                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $orders->links() }}
    </div>

    {{-- Modal chi tiết --}}
    @if($selectedOrder)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Chi tiết đơn hàng #{{ $selectedOrder->id }}</h2>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>

                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>👤 Khách hàng:</strong> {{ $selectedOrder->user->name }}</p>
                    <p><strong>📧 Email:</strong> {{ $selectedOrder->user->email }}</p>
                    <p><strong>💰 Tổng tiền:</strong> {{ number_format($selectedOrder->total_amount, 0, ',', '.') }}đ</p>
                    <p><strong>📦 Trạng thái:</strong> {{ ucfirst($selectedOrder->status) }}</p>
                    <p><strong>🕒 Ngày tạo:</strong> {{ $selectedOrder->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="mt-4">
                    <h3 class="font-bold mb-2">🛒 Sản phẩm:</h3>
                    <ul class="list-disc list-inside text-gray-600 text-sm space-y-1">
                        @foreach($selectedOrder->orderItems as $item)
                            <li>
                                {{ $item->product->name }} – SL: {{ $item->quantity }} – Giá: {{ number_format($item->price, 0, ',', '.') }}đ
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6 text-right">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
