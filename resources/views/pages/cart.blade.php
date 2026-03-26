@extends('layouts.app')

@section('title', 'Мій кошик | Spark')

@section('content')
    <div class="mb-6">
        <h1 class="text-4xl font-bold">🛒 Мій Кошик</h1>
    </div>

    @if($cartItems->count())
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    @foreach($cartItems as $item)
                        <div class="flex gap-4 pb-6 border-b last:border-b-0">
                            <!-- Product Image -->
                            <div class="w-24 h-24 bg-gray-100 rounded flex-shrink-0">
                                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/100x100?text=' . urlencode($item->product->name) }}" 
                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="font-bold text-lg hover:text-yellow-500">
                                    <a href="{{ route('products.show', $item->product->slug) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600">SKU: {{ $item->product->sku }}</p>
                                <p class="text-xl font-bold text-red-600 mt-2">₴{{ number_format($item->product->price, 0, ',', ' ') }}</p>
                            </div>

                            <!-- Quantity & Actions -->
                            <div class="flex flex-col items-end gap-4">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                        class="w-16 px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                        onchange="this.form.submit()">
                                </form>

                                <p class="text-lg font-bold">₴{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }}</p>

                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Видалити?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">
                                        ✕ Видалити
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Continue Shopping -->
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="text-yellow-500 hover:text-yellow-600 font-semibold">
                        ← Продовжити Покупки
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 sticky top-24">
                    <h2 class="text-2xl font-bold mb-6">Підсумок</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span>Кількість товарів:</span>
                            <span class="font-semibold">{{ $cartItems->sum('quantity') }}</span>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between mb-3">
                                <span>Сума товарів:</span>
                                <span class="font-semibold">₴{{ number_format($subtotal, 0, ',', ' ') }}</span>
                            </div>

                            <div class="flex justify-between mb-3">
                                <span>ПДВ (20%):</span>
                                <span class="font-semibold">₴{{ number_format($tax, 0, ',', ' ') }}</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Доставка:</span>
                                <span class="text-green-600 font-semibold">Безплатна</span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Всього:</span>
                                <span class="text-red-600">₴{{ number_format($total, 0, ',', ' ') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('orders.checkout') }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-4 rounded-lg transition text-center text-lg mt-6">
                            💳 Перейти до Оформлення
                        </a>

                        <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg transition">
                            Продовжити Покупки
                        </button>
                    </div>

                    <!-- Promo Code -->
                    <div class="mt-8 pt-6 border-t">
                        <p class="text-sm text-gray-600 mb-2">У вас є промокод?</p>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Введіть промокод" class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold px-4 rounded transition">
                                Застосувати
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="mt-6 space-y-3 text-sm text-gray-600">
                    <div class="flex gap-2">
                        <span>🔒</span>
                        <span>Безпечне оплачення</span>
                    </div>
                    <div class="flex gap-2">
                        <span>🚚</span>
                        <span>Швидка доставка по Україні</span>
                    </div>
                    <div class="flex gap-2">
                        <span>↩️</span>
                        <span>Легке повернення протягом 14 днів</span>
                    </div>
                    <div class="flex gap-2">
                        <span>💬</span>
                        <span>Підтримка на українській мові</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-3xl font-bold mb-2">Ваш кошик порожній</h2>
            <p class="text-gray-600 mb-8">Додайте товари для оформлення замовлення</p>

            <a href="{{ route('products.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-8 py-3 rounded-lg transition">
                🛍️ Розпочати Покупки
            </a>

            <!-- Helpful Links -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="font-bold mb-2">Популярні Категорії</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li><a href="{{ route('products.index', ['category' => 'smartphones']) }}" class="hover:text-yellow-500">📱 Смартфони</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'laptops']) }}" class="hover:text-yellow-500">💻 Ноутбуки</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'tablets']) }}" class="hover:text-yellow-500">📊 Планшети</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold mb-2">Акції</h3>
                    <p class="text-sm text-gray-600">Перевірте наші спеціальні пропозиції та знижки</p>
                </div>

                <div>
                    <h3 class="font-bold mb-2">Потребуєте Допомогу?</h3>
                    <p class="text-sm text-gray-600">
                        <a href="#" class="text-yellow-500 hover:underline">Зв'яжіться з нами</a><br>
                        Доступні 24/7
                    </p>
                </div>
            </div>
        </div>
    @endif
@endsection
