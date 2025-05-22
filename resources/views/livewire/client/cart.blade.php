<div>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Giỏ hàng</h1>
    </div>

    @if(empty($cart))
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg mb-4">Giỏ hàng trống</p>
            <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                @foreach($cart as $productId => $item)
                    <div class="flex items-center justify-between border-b border-gray-200 py-4 last:border-0">
                        <div class="flex items-center space-x-4">
                            @if($item['image'])
                                <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500 text-xs">No img</span>
                                </div>
                            @endif
                            
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-gray-500">{{ number_format($item['price'], 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <button 
                                    wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                    class="bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300"
                                >-</button>
                                
                                <span class="w-8 text-center">{{ $item['quantity'] }}</span>
                                
                                <button 
                                    wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                    class="bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300"
                                >+</button>
                            </div>
                            
                            <span class="font-medium text-gray-900 w-24 text-right">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                            </span>
                            
                            <button 
                                wire:click="removeFromCart({{ $productId }})"
                                class="text-red-500 hover:text-red-700"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-bold text-gray-900">Tổng cộng:</span>
                    <span class="text-2xl font-bold text-blue-600">
                        {{ number_format($this->getTotal(), 0, ',', '.') }}đ
                    </span>
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Ghi chú đơn hàng:</label>
                    <textarea 
                        wire:model="notes" 
                        id="notes"
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nhập ghi chú cho đơn hàng (tùy chọn)..."
                    ></textarea>
                </div>

                <button 
                    wire:click="checkout"
                    class="w-full bg-green-500 text-white py-3 px-6 rounded-lg font-medium hover:bg-green-600 transition duration-200"
                >
                    Đặt hàng
                </button>
            </div>
        </div>
    @endif
</div>