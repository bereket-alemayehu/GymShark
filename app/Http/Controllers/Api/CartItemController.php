<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // Add a product variant to the cart
    public function store(Request $request, $productVariantId)
    {
        // Validate incoming request
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Get the user's active cart
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active']
        );

        $productVariant = ProductVariant::findOrFail($productVariantId);

        // Check if the product variant already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $productVariant->id)
            ->first();

        if ($cartItem) {
            // If it exists, update the quantity and total price
            $cartItem->quantity += $request->quantity;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
        } else {
            // Otherwise, create a new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $productVariant->id,
                'quantity' => $request->quantity,
                //'price' => $productVariant->price,
                'total_price' => $request->quantity * $productVariant->price,
            ]);
        }

        return new CartItemResource($cartItem);
    }

    // Update a cart item (quantity and total price)
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->quantity = $request->quantity;
        $cartItem->total_price = $cartItem->quantity * $cartItem->price;
        $cartItem->save();

        return new CartItemResource($cartItem);
    }

    // Remove a cart item
    public function destroy($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart'], 200);
    }
}
