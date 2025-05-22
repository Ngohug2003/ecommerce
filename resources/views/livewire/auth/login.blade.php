
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="max-full w-96 mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Đăng nhập</h2>
        <form wire:submit.prevent="login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" id="email" class="w-full px-4 py-2 border rounded-lg">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <input type="password" wire:model="password" id="password" class="w-full px-4 py-2 border rounded-lg">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Đăng nhập
            </button>
        </form>
    </div>
</div>