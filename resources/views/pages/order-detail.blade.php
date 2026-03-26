@extends('layouts.app')

@section('title', 'Замовлення #' . $order->order_number . ' | Spark')

@section('content')
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-yellow-500 hover:underline">← Назад до замовлень</a>
        <h1 class="text-4xl font-bold mt-2">Замовлення #{{ $order->order_number }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Статус Замовлення</h2>

                <div class="flex items-center justify-between mb-6 relative">
                    @php
                        $statuses = ['pending' => 'Очікування', 'confirmed' => 'Підтверджено', 'processing' => 'Обробка', 'shipped' => 'Відправлено', 'delivered' => 'Доставлено'];
                        $statusValues = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                        $currentIndex = array_search($order->status, $statusValues);
                    @endphp

                    @foreach($statusValues as $index => $status)
                        <div class="flex flex-col items-center @if($index < count($statusValues) - 1) flex-1 @endif">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white
                                @if($index <= $currentIndex) bg-green-500 @else bg-gray-300 @endif">
                                ✓
                            </div>
                            <p class="text-sm text-center mt-2">{{ $statuses[$status] }}</p>
                        </div>

                        @if($index < count($statusValues) - 1)
                            <div class="h-1 bg-gray-300 @if($index < $currentIndex) bg-green-500 @endif flex-1 mx-2"></div>
                        @endif
                    @endforeach
                </div>

                <p class="text-gray-700 text-center">
                    <strong>Статус:</strong> {{ $statuses[$order->status] }} | 
                    <strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}
                </p>
            </div>

            <!-- Delivery Info -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">📍 Інформація про Доставку</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 font-semibold">Адреса Доставки:</p>
                        <p class="text-lg">{{ $order->delivery_address }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600 font-semibold">Спосіб Доставки:</p>
                        <p class="text-lg">
                            @switch($order->delivery_method)
                                @case('nova_poshta')
                                    Nova Poshta (Нова Пошта)
                                    @break
                                @case('meest')
                                    Meest Express
                                    @break
                                @case('pickup')
                                    Самовивіз (Pickup)
                                    @break
                            @endswitch
                        </p>
                    </div>
                </div>

                @if($order->shipped_at)
                    <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        ✓ Відправлено {{ $order->shipped_at->format('d.m.Y H:i') }}
                    </div>
                @endif

                @if($order->delivered_at)
                    <div class="mt-2 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        ✓ Доставлено {{ $order->delivered_at->format('d.m.Y H:i') }}
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Товари в Замовленні</h2>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b last:border-b-0">
                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/80x80?text=' . urlencode($item->product->name) }}" 
                                alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded bg-gray-100">

                            <div class="flex-1">
                                <h3 class="font-bold text-lg">
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-yellow-500">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600">SKU: {{ $item->product->sku }}</p>
                                <p class="text-sm mt-2">Кількість: <strong>{{ $item->quantity }}x</strong> × ₴{{ number_format($item->price, 0, ',', ' ') }}</p>
                            </div>

                            <div class="text-right">
                                <p class="text-lg font-bold">₴{{ number_format($item->subtotal, 0, ',', ' ') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">💳 Інформація про Оплату</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 font-semibold">Спосіб Оплати:</p>
                        <p class="text-lg">
                            @switch($order->payment_method)
                                @case('card')
                                    Карта Visa/Mastercard (Stripe)
                                    @break
                                @case('liqpay')
                                    LiqPay
                                    @break
                                @case('transfer')
                                    Банківський перевід
                                    @break
                                @case('cash')
                                    Готівка при отриманні
                                    @break
                            @endswitch
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 font-semibold">Статус Оплати:</p>
                        <p class="text-lg">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($order->payment_status == 'paid') bg-green-100 text-green-700
                                @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700
                                @endif">
                                @switch($order->payment_status)
                                    @case('pending')
                                        Очікування
                                        @break
                                    @case('paid')
                                        Оплачено
                                        @break
                                    @case('failed')
                                        Помилка
                                        @break
                                @endswitch
                            </span>
                        </p>
                    </div>
                </div>

                @if($order->paid_at)
                    <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        ✓ Оплачено {{ $order->paid_at->format('d.m.Y H:i') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 sticky top-24">
                <h2 class="text-2xl font-bold mb-6">Підсумок</h2>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span>Сума товарів:</span>
                        <span class="font-semibold">₴{{ number_format($order->total_amount - $order->tax - $order->shipping_cost, 0, ',', ' ') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>ПДВ (20%):</span>
                        <span class="font-semibold">₴{{ number_format($order->tax, 0, ',', ' ') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Доставка:</span>
                        <span class="font-semibold">₴{{ number_format($order->shipping_cost, 0, ',', ' ') }}</span>
                    </div>

                    <div class="border-t pt-3 flex justify-between text-xl font-bold">
                        <span>Всього:</span>
                        <span class="text-red-600">₴{{ number_format($order->total_amount, 0, ',', ' ') }}</span>
                    </div>
                </div>

                @if($order->payment_status == 'pending' && in_array($order->payment_method, ['card', 'liqpay']))
                    <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg transition mb-3">
                        💳 Оплатити Зараз
                    </button>
                @endif

                <a href="{{ route('products.index') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg transition">
                    Продовжити Покупки
                </a>

                <!-- Notes -->
                @if($order->notes)
                    <div class="mt-6 p-4 bg-white border rounded-lg">
                        <p class="text-sm font-semibold mb-2">Примітки:</p>
                        <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                    </div>
                @endif

                <!-- Support -->
                <div class="mt-6 p-4 bg-blue-100 border border-blue-300 rounded-lg text-sm text-blue-700">
                    <p class="font-semibold mb-2">Потребуєте допомогу?</p>
                    <p>Зв'яжіться з нами по телефону<br><strong>0-800-500-005</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection
