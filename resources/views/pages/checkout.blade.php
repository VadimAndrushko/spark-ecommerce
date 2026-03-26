@extends('layouts.app')

@section('title', 'Оформлення Замовлення | Spark')

@section('content')
    <div class="mb-6">
        <h1 class="text-4xl font-bold">💳 Оформлення Замовлення</h1>
    </div>

    @if(auth()->user()->cartItems->count() == 0)
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-gray-600 mb-4">Ваш кошик порожній!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-3 rounded transition">
                ← Повернутися до Покупок
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Step 1: Shipping Address -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <span class="bg-yellow-500 text-black rounded-full w-8 h-8 flex items-center justify-center font-bold">1</span>
                            Адреса Доставки
                        </h2>

                        <div class="space-y-4">
                            <!-- Saved Addresses -->
                            @if(auth()->user()->addresses->count() > 0)
                                <div class="mb-6">
                                    <label class="font-semibold mb-3 block">Оберіть збережену адресу:</label>
                                    <div class="space-y-3">
                                        @foreach(auth()->user()->addresses as $address)
                                            <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50"
                                                :class="{ 'border-yellow-500 bg-yellow-50': selected == {{ $address->id }} }">
                                                <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1 accent-yellow-500">
                                                <div>
                                                    <p class="font-semibold">{{ $address->names }}</p>
                                                    <p class="text-sm text-gray-600">{{ $address->address }}, {{ $address->city }}</p>
                                                    <p class="text-sm text-gray-600">{{ $address->postal_code }} • {{ $address->country }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="border-t pt-6">
                                    <button type="button" onclick="document.getElementById('new-address').style.display = document.getElementById('new-address').style.display === 'none' ? 'block' : 'none'"
                                        class="text-yellow-500 hover:underline font-semibold">
                                        + Додати нову адресу
                                    </button>
                                </div>
                            @endif

                            <!-- New Address Form -->
                            <div id="new-address" class="@if(auth()->user()->addresses->count() > 0) hidden @endif border-t pt-6 space-y-4">
                                <h3 class="font-semibold">Нова адреса</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Назва (опис) *</label>
                                        <input type="text" name="address_names" placeholder="Мій дім, Робота" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Телефон *</label>
                                        <input type="tel" name="address_phone" placeholder="+380 XX XXX XXXX" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2">Адреса *</label>
                                    <input type="text" name="address_address" placeholder="Вулиця, будинок, квартира" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Місто *</label>
                                        <input type="text" name="address_city" placeholder="Київ" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Поштовий індекс</label>
                                        <input type="text" name="address_postal_code" placeholder="01000" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Країна</label>
                                        <input type="text" name="address_country" value="Україна" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Shipping Method -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <span class="bg-yellow-500 text-black rounded-full w-8 h-8 flex items-center justify-center font-bold">2</span>
                            Спосіб Доставки
                        </h2>

                        <div class="space-y-3">
                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="delivery_method" value="nova_poshta" class="mt-1 accent-yellow-500" checked>
                                <div class="flex-1">
                                    <p class="font-semibold">Nova Poshta (Нова Пошта)</p>
                                    <p class="text-sm text-gray-600">Доставка 1-3 дні до відділення або додому</p>
                                    <p class="text-sm text-yellow-600 font-semibold">Від ₴50</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="delivery_method" value="meest" class="mt-1 accent-yellow-500">
                                <div class="flex-1">
                                    <p class="font-semibold">Meest Express</p>
                                    <p class="text-sm text-gray-600">Доставка 2-4 дні по всій Україні</p>
                                    <p class="text-sm text-yellow-600 font-semibold">Від ₴40</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="delivery_method" value="pickup" class="mt-1 accent-yellow-500">
                                <div class="flex-1">
                                    <p class="font-semibold">Самовивіз (Pickup)</p>
                                    <p class="text-sm text-gray-600">Безплатно. Готово за 2 години</p>
                                    <p class="text-sm text-green-600 font-semibold">Безплатна</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Step 3: Payment Method -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <span class="bg-yellow-500 text-black rounded-full w-8 h-8 flex items-center justify-center font-bold">3</span>
                            Спосіб Оплати
                        </h2>

                        <div class="space-y-3">
                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="payment_method" value="card" class="mt-1 accent-yellow-500" checked>
                                <div class="flex-1">
                                    <p class="font-semibold">💳 Карта Visa/Mastercard</p>
                                    <p class="text-sm text-gray-600">Безпечна онлайн оплата через Stripe</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="payment_method" value="liqpay" class="mt-1 accent-yellow-500">
                                <div class="flex-1">
                                    <p class="font-semibold">💰 LiqPay</p>
                                    <p class="text-sm text-gray-600">Популярний український платіжний сервіс</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="payment_method" value="transfer" class="mt-1 accent-yellow-500">
                                <div class="flex-1">
                                    <p class="font-semibold">🏦 Банківський перевід</p>
                                    <p class="text-sm text-gray-600">Оплата на рахунок компанії</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                <input type="radio" name="payment_method" value="cash" class="mt-1 accent-yellow-500">
                                <div class="flex-1">
                                    <p class="font-semibold">💵 Готівка при отриманні</p>
                                    <p class="text-sm text-gray-600">Оплатити при отриманні посилки</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Terms & Notes -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <label class="flex items-start gap-3">
                            <input type="checkbox" name="agree_terms" class="mt-1 accent-yellow-500" required>
                            <span class="text-sm text-gray-700">
                                Я погоджуюсь з 
                                <a href="#" class="text-yellow-500 hover:underline">умовами доставки</a> та
                                <a href="#" class="text-yellow-500 hover:underline">політикою повернень</a>
                            </span>
                        </label>

                        <textarea name="notes" placeholder="Додаткові примітки до замовлення..." class="w-full mt-4 px-4 py-3 border rounded-lg focus:ring-2 focus:ring-yellow-400" rows="3"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-4 rounded-lg transition text-lg">
                        ✓ Оформити Замовлення
                    </button>
                </form>
            </div>

            <!-- Order Summary (Sidebar) -->
            <div class="lg:col-span-1">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 sticky top-24">
                    <h2 class="text-2xl font-bold mb-6">Ваше Замовлення</h2>

                    <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                        @php
                            $subtotal = auth()->user()->cartItems->sum(fn($item) => $item->product->price * $item->quantity);
                            $tax = round($subtotal * 0.2, 2);
                            $total = $subtotal + $tax;
                        @endphp

                        @foreach(auth()->user()->cartItems->load('product') as $item)
                            <div class="flex justify-between pb-3 border-b">
                                <div>
                                    <p class="font-semibold text-sm">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-600">x{{ $item->quantity }}</p>
                                </div>
                                <span class="font-bold">₴{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 border-t pt-4">
                        <div class="flex justify-between">
                            <span>Сума товарів:</span>
                            <span class="font-semibold">₴{{ number_format($subtotal, 0, ',', ' ') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>ПДВ (20%):</span>
                            <span class="font-semibold">₴{{ number_format($tax, 0, ',', ' ') }}</span>
                        </div>

                        <div class="flex justify-between text-gray-600">
                            <span>Доставка:</span>
                            <span class="text-green-600 font-semibold">калькулюється</span>
                        </div>

                        <div class="border-t pt-3 flex justify-between text-xl font-bold">
                            <span>Всього:</span>
                            <span class="text-red-600">₴{{ number_format($total, 0, ',', ' ') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-white rounded-lg">
                        <h3 class="font-semibold mb-3">Способи оплати</h3>
                        <img src="https://via.placeholder.com/200x40?text=Visa+Mastercard" alt="Cards" class="w-full mb-2">
                        <img src="https://via.placeholder.com/200x40?text=LiqPay" alt="LiqPay" class="w-full">
                    </div>

                    <div class="mt-4 text-xs text-gray-600 space-y-1">
                        <p>✓ Безпечна оплата</p>
                        <p>✓ 100% захист покупця</p>
                        <p>✓ Простий повернення</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
