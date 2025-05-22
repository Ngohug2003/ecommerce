<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Thông tin cá nhân</h1>
    <div class="space-y-4">
        <div>
            <strong>Tên:</strong>
            <p>{{ $user->name }}</p>
        </div>
        <div>
            <strong>Email:</strong>
            <p>{{ $user->email }}</p>
        </div>
        <div>
            <strong>Ngày tạo tài khoản:</strong>
            <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
        </div>
       
    </div>
</div>