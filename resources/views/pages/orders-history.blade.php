@extends('layouts.app')

@section('title', 'Мої Замовлення | Spark')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold">📦 Мої Замовлення</h1>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold">{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>

                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            @if($order->status == 'delivered') bg-green-100 text-green-700
                            @elseif($order->status == 'shipped') bg-blue-100 text-blue-700
                            @elseif($order->status == 'processing') bg-purple-100 text-purple-700
                            @elseif($order->status == 'confirmed') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            @switch($order->status)
                                @case('pending')
                                    Очікування
                                    @break
                                @case('confirmed')
                                    Підтверджено
                                    @break
                                @case('processing')
                                    Обробка
                                    @break
                                @case('shipped')
                                    Відправлено
                                    @break
                                @case('delivered')
                                    Доставлено
                                    @break
                            @endswitch
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Товарів</p>
                            <p class="text-lg font-bold">{{ $order->items->count() }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Сума</p>
                            <p class="text-lg font-bold text-red-600">₴{{ number_format($order->total_amount, 0, ',', ' ') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Доставка</p>
                            <p class="text-lg font-bold">
                                @switch($order->delivery_method)
                                    @case('nova_poshta')
                                        Nova Poshta
                                        @break
                                    @case('meest')
                                        Meest
                                        @break
                                    @case('pickup')
                                        Самовивіз
                                        @break
                                @endswitch
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Оплата</p>
                            <p class="text-lg font-bold">
                                <span class="px-2 py-1 rounded text-sm font-semibold
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

                    <!-- Order Items Preview -->
                    <div class="mb-4 flex gap-2 flex-wrap">
                        @foreach($order->items->take(3) as $item)
                            <div class="relative group">
                                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/60x60?text=' . urlencode($item->product->name) }}" 
                                    alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded border border-gray-200">
                                <div class="absolute top-0 right-0 bg-yellow-500 text-black text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $item->quantity }}
                                </div>
                                <div class="absolute left-0 bottom-full mb-2 bg-gray-800 text-white text-xs rounded p-2 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                                    {{ $item->product->name }}
                                </div>
                            </div>
                        @endforeach

                        @if($order->items->count() > 3)
                            <div class="w-16 h-16 bg-gray-100 border border-gray-300 rounded flex items-center justify-center font-bold text-gray-600">
                                +{{ $order->items->count() - 3 }}
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('orders.show', $order->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded transition text-center">
                            Переглянути Замовлення
                        </a>

                        <button class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded transition">
                            Повторити Замовлення
                        </button>

                        @if($order->payment_status == 'pending' && in_array($order->payment_method, ['card', 'liqpay']))
                            <button class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-2 rounded transition">
                                Оплатити
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty Orders -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-3xl font-bold mb-2">У вас немає замовлень</h2>
            <p class="text-gray-600 mb-8">Почніть робити покупки, щоб побачити ваші замовлення тут</p>

            <a href="{{ route('products.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-8 py-3 rounded-lg transition">
                🛍️ Почати Покупки
            </a>

            <!-- Popular Products -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold mb-6">Популярні Товари</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach(\App\Models\Product::where('is_active', true)->orderByDesc('review_count')->limit(4)->get() as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
