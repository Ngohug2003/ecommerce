<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Quản lý sản phẩm</h1>
        <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Thêm sản phẩm
        </button>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <table class="min-w-full table-auto divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Tên</th>
                    <th class="px-6 py-3 text-left">Giá</th>
                    <th class="px-6 py-3 text-left">Tồn kho</th>
                    <th class="px-6 py-3 text-left">Trạng thái</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach ($products as $product)
                <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($product->price, 0, ',', '.') }}đ
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->stock_quantity }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button wire:click="edit({{ $product->id }})"
                                class="text-blue-600 hover:text-blue-900">Sửa</button>
                            <button wire:click="delete({{ $product->id }})"
                                class="text-red-600 hover:text-red-900">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

    {{-- Modal thêm/sửa sản phẩm --}}
    @if ($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center px-4">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-6 md:p-8 space-y-6 relative">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-3">
                {{ $editingProduct ? 'Sửa sản phẩm' : 'Thêm sản phẩm' }}
            </h3>
    
            <form wire:submit.prevent="save" class="space-y-5">
                <!-- Tên sản phẩm -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                    <input type="text" wire:model="name"
                        class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Mô tả -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mô tả</label>
                    <textarea wire:model="description" rows="3"
                        class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200"></textarea>
                </div>
    
                <!-- Giá và Tồn kho -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Giá</label>
                        <input type="number" wire:model="price"
                            class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tồn kho</label>
                        <input type="number" wire:model="stock_quantity"
                            class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                        @error('stock_quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                <!-- Hình ảnh -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                    <input type="file" wire:model="image"
                        class="mt-1 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Trạng thái hoạt động -->
                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_active" class="rounded text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Hoạt động</span>
                </div>
    
                <!-- Nút hành động -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                        {{ $editingProduct ? 'Cập nhật' : 'Tạo' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @endif
</div>
