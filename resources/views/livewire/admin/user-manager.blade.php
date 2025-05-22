<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg"> {{ session('success') }} </div>
        @endif @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg"> {{ session('error') }} </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Quản lý thành viên</h1> <button wire:click="create"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"> Thêm thành viên </button>
        </div>
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <table class="min-w-full table-auto divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Tên</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm space-x-2"> <button wire:click="edit({{ $user->id }})"
                                    class="text-blue-600 hover:text-blue-900">Sửa</button> <button
                                    wire:click="delete({{ $user->id }})"
                                    class="text-red-600 hover:text-red-900">Xóa</button> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6"> {{ $users->links() }} </div> {{-- Modal thêm/sửa thành viên --}} @if ($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center px-4">
                <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-6 md:p-8 space-y-6 relative">
                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-3">
                        {{ $editingUser ? 'Sửa thành viên' : 'Thêm thành viên' }} </h3>
                    <form wire:submit.prevent="save" class="space-y-5"> <!-- Tên thành viên -->
                        <div> <label class="block text-sm font-medium text-gray-700">Tên thành viên</label> <input
                                type="text" wire:model="name"
                                class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="email"
                                class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                        </div>

                        @if (!$editingUser)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                                <input type="password" wire:model="password"
                                    class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu</label>
                                <input type="password" wire:model="password_confirmation"
                                    class="mt-1 block w-full border rounded-lg px-4 py-2 text-sm border-gray-300 focus:ring focus:ring-blue-200">
                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-4">
                            <label for="is_admin" class="block mb-1 text-sm font-medium text-gray-700">Quyền</label>
                            <div class="relative">
                                <select id="is_admin" wire:model="is_admin"
                                    class="w-full appearance-none border border-gray-300 bg-white text-gray-700 py-2 px-3 pr-10 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                    <option value="0">Người dùng</option>
                                    <option value="1">Admin</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('is_admin')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end space-x-3 pt-4 border-t"> <button type="button"
                                wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100">
                                Hủy </button> <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                                {{ $editingUser ? 'Cập nhật' : 'Tạo' }} </button>


                        </div>
                    </form>
                </div>
            </div>
        @endif
</div>
