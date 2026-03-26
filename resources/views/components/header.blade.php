<header class="bg-white shadow sticky top-0 z-50">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between">
            <div class="flex gap-6">
                <a href="#" class="hover:text-yellow-400">Доставка</a>
                <a href="#" class="hover:text-yellow-400">Повернення</a>
                <a href="#" class="hover:text-yellow-400">Про нас</a>
                <a href="#" class="hover:text-yellow-400">Контакти</a>
            </div>
            <div class="flex gap-4">
                <span>☎️ 0-800-500-005</span>
                <span>✉️ support@spark.ua</span>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between mb-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-bold text-yellow-500">⚡ SPARK</a>

            <!-- Search -->
            <form action="{{ route('products.index') }}" method="GET" class="flex-1 mx-8">
                <input type="text" name="search" placeholder="Пошук товарів..." 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </form>

            <!-- Icons -->
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ route('profile.show') }}" class="relative">❤️
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ auth()->user()->wishlists->count() }}
                        </span>
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="relative">🛒
                    <span class="absolute -top-2 -right-2 bg-yellow-500 text-black text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                        @if(auth()->check())
                            {{ auth()->user()->cartItems->count() }}
                        @else
                            0
                        @endif
                    </span>
                </a>

                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2">👤 {{ auth()->user()->name }}</button>
                        <div class="absolute right-0 mt-0 w-48 bg-white border rounded shadow-lg opacity-0 group-hover:opacity-100 transition pointer-events-none group-hover:pointer-events-auto z-10">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Профіль</a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">Мої замовлення</a>
                            <form action="{{ route('logout') }}" method="POST" class="inline w-full">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Вихід</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login.show') }}" class="px-4 py-2 bg-yellow-500 text-black rounded hover:bg-yellow-600 transition">Вхід</a>
                    <a href="{{ route('register.show') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Реєстрація</a>
                @endauth
            </div>
        </div>

        <!-- Category Menu -->
        <nav class="border-t pt-2 overflow-x-auto flex gap-4">
            @foreach(App\Models\Category::where('is_active', true)->limit(8)->get() as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                    class="whitespace-nowrap px-3 py-1 hover:text-yellow-500 transition">
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
