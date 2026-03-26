<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'review' => $validated['review']
        ]);

        // Update product rating
        $avgRating = $product->reviews()->avg('rating');
        $reviewCount = $product->reviews()->count();
        $product->update([
            'rating' => round($avgRating, 1),
            'review_count' => $reviewCount
        ]);

        return back()->with('success', 'Дякуємо за ваш відгук!');
    }
}
