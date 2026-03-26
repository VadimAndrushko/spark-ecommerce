<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $tax = round($subtotal * 0.2, 2); // 20% VAT in Ukraine
        $total = $subtotal + $tax;

        return view('pages.cart', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $validated['quantity'] ?? 1;

        if ($product->stock_quantity < $quantity) {
            return back()->with('error', 'Недостатня кількість товару в наявності');
        }

        $cartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            auth()->user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return back()->with('success', $product->name . ' додано до кошика');
    }

    public function update(Request $request, CartItem $item)
    {
        if ($item->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($item->product->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Недостатня кількість товару');
        }

        $item->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Кошик оновлено');
    }

    public function remove(CartItem $item)
    {
        if ($item->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $item->delete();

        return back()->with('success', 'Товар видалено з кошика');
    }
}
