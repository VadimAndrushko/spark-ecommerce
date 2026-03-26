<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        if (auth()->user()->cartItems->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній');
        }

        return view('pages.checkout');
    }

    public function store(Request $request)
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній');
        }

        $validated = $request->validate([
            'address_id' => 'nullable|integer|exists:addresses,id',
            'address_names' => 'nullable|string',
            'address_phone' => 'nullable|string',
            'address_address' => 'nullable|string',
            'address_city' => 'nullable|string',
            'address_postal_code' => 'nullable|string',
            'address_country' => 'nullable|string',
            'delivery_method' => 'required|in:nova_poshta,meest,pickup',
            'payment_method' => 'required|in:card,liqpay,transfer,cash',
            'agree_terms' => 'required|accepted',
            'notes' => 'nullable|string'
        ]);

        // Calculate totals
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $tax = round($subtotal * 0.2, 2);
        $shipping = $validated['delivery_method'] == 'pickup' ? 0 : 50;
        $total = $subtotal + $tax + $shipping;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . time(),
            'status' => 'pending',
            'total_amount' => $total,
            'shipping_cost' => $shipping,
            'tax' => $tax,
            'delivery_address' => $validated['address_address'] ?? $validated['address_names'],
            'delivery_method' => $validated['delivery_method'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'notes' => $validated['notes'] ?? null
        ]);

        // Create order items from cart
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity
            ]);

            // Decrease product stock
            $item->product->decrement('stock_quantity', $item->quantity);
        }

        // Clear cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Замовлення успішно створено! Номер замовлення: ' . $order->order_number);
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('pages.orders-history', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('home')->with('error', 'Доступ заборонений');
        }

        return view('pages.order-detail', compact('order'));
    }
}
