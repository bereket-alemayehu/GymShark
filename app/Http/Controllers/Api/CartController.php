<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty or not found'], 404);
        }

        return new CartResource($cart->load('cartItems.productVariant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productVariantId)
    {
        // Validate the quantity coming from the request
        $request->validate([
            'quantity' => 'required|integer|min:1', // Ensure valid quantity
        ]);

        // Find the product variant by ID
        $productVariant = ProductVariant::findOrFail($productVariantId);

        // Get or create the user's active cart
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active']
        );

        // Get the price from the product (assuming your Product model has a price)
        $price = $productVariant->product->price ?? 0;

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
                'price' => $price,
                'total_price' => $request->quantity * $price,
            ]);
        }

        return new CartResource($cart->load('cartItems.productVariant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $cartItemId)
            ->where('cart_id', Auth::user()->cart->id) // Ensure the cart item belongs to the user's cart
            ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->total_price = $cartItem->quantity * $cartItem->price;
        $cartItem->save();

        return new CartItemResource($cartItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cartItemId)
    {
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('cart_id', Auth::user()->cart->id) // Ensure the cart item belongs to the user's cart
            ->firstOrFail();

        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart'], 200);
    }

    /**
     * Checkout the cart.
     */
    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty'], 400);
        }

        // Create the order from the cart items
        $order = $this->createOrderFromCart($cart);

        // Mark the cart as 'ordered' after checkout
        $cart->status = 'ordered';
        $cart->save();

        return response()->json(['message' => 'Checkout successful', 'order_id' => $order->id], 200);
    }

    /**
     * Create an order from the cart items.
     */
    private function createOrderFromCart(Cart $cart)
    {
        // Create the order
        $order = Order::create([
            'user_id' => $cart->user_id,
            'total_price' => $cart->cartItems->sum('total_price'),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'shipping_address' => 'User shipping address', // Replace with actual user input data
            'billing_address' => 'User billing address', // Replace with actual user input data
            'shipping_method' => 'Standard', // Replace with actual method if needed
            'payment_method' => 'Credit Card', // Replace with actual method if needed
        ]);

        // Create order items from cart items
        foreach ($cart->cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_variant_id' => $cartItem->product_variant_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'total_price' => $cartItem->total_price,
            ]);
        }

        return $order;
    }
}
