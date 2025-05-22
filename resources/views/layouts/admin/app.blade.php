<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống đặt hàng')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-lg w-full fixed top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 ">
                <div class="flex items-center">
                    <a href="{{ route('products.index') }}" class="text-xl font-bold text-gray-800">
                        Quản Lý Cửa Hàng
                    </a>
                </div>

                <div class="flex items-center space-x-8">
                    <a href="{{ route('admin.products') }}" class="text-gray-600 hover:text-gray-900">
                        Quản Lý Sản Phẩm
                    </a>
                    <a href="{{ route('admin.orders') }}" class="text-gray-600 hover:text-gray-900">
                        Quản Lý Đơn Hàng
                    </a>
                    <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-900">
                        Quản Lý Users
                    </a>
                    <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-gray-900">
                        Thông tin cá nhân 
                    </a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">
                                Đăng xuất
                            </button>
                        </form>


                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 py-8 pt-24">

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @livewireScripts
</body>

</html>
