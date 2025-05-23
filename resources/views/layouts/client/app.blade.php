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
                        Cửa hàng
                    </a>
                </div>

                <div class="flex items-center space-x-8">
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">
                        Sản phẩm
                    </a>
                    <livewire:cart-counter />

                    @auth
                        <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900">
                            Đơn hàng
                        </a>
                        <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-gray-900">
                            Thông tin cá nhân
                        </a>
                        @if (auth()->user()->isAdmin())
                            <div class="relative group inline-block">
                                <button class="text-gray-600 hover:text-gray-900 px-4 py-2 bg-white rounded-md">
                                    Admin
                                </button>

                                <div
                                    class="absolute right-0 mt-1 w-48 z-40 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('admin.products') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Quản lý sản phẩm
                                    </a>
                                    <a href="{{ route('admin.orders') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Quản lý đơn hàng
                                    </a>
                                    <a href="{{ route('admin.users') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Quản lý users
                                </a>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">
                                Đăng xuất
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Đăng ký
                        </a>
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
