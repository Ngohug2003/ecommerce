<div>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Danh sách sản phẩm</h1>

        <div class="mb-4">
            <input type="text" wire:model.live="search" placeholder="Tìm kiếm sản phẩm..."
                class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Không có ảnh</span>
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>

                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xl font-bold text-blue-600">
                            {{ number_format($product->price, 0, ',', '.') }}đ
                        </span>
                        <span class="text-sm text-gray-500">
                            Còn: {{ $product->stock_quantity }}
                        </span>
                    </div>

                    @if ($product->stock_quantity > 0)
                        <button wire:click="addToCart({{ $product->id }})"
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                            Thêm vào giỏ
                        </button>
                    @else
                        <button disabled
                            class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                            Hết hàng
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
