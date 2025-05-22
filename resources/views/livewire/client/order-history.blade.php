<div>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Lịch sử đơn hàng</h1>
    </div>

    @if($orders->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mã đơn hàng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày đặt
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tổng tiền
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hành động
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($order->total_amount, 0, ',', '.') }}đ
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button 
                                    wire:click="viewOrder({{ $order->id }})"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    Xem chi tiết
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg mb-4">Chưa có đơn hàng nào</p>
            <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                Bắt đầu mua sắm
            </a>
        </div>
    @endif

    {{-- Modal chi tiết đơn hàng --}}
    @if($selectedOrder)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Chi tiết đơn hàng #{{ $selectedOrder->id }}</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach($selectedOrder->orderItems as $item)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <h4 class="font-medium">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-500">{{ number_format($item->price, 0, ',', '.') }}đ x {{ $item->quantity }}</p>
                            </div>
                            <span class="font-medium">{{ number_format($item->total, 0, ',', '.') }}đ</span>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center font-bold text-lg border-t pt-2">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($selectedOrder->total_amount, 0, ',', '.') }}đ</span>
                    </div>

                    @if($selectedOrder->notes)
                        <div class="mt-4">
                            <strong>Ghi chú:</strong>
                            <p class="text-gray-600">{{ $selectedOrder->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
