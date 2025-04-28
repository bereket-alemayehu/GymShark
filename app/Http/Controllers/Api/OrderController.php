<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        $totalPrice = $cart->cartItems->sum(function ($item) {
            return $item->totalPrice;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
        ]);

        foreach ($cart->cartItems as $cartItem) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_variant_id' => $cartItem->product_variant_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->productVariant->price,
            ]);
        }

        // Now handle the payment process (example: Chapa API)
        $payment = $this->processPayment($order, $totalPrice);

        return response()->json([
            'order' => $order,
            'payment' => $payment,
        ]);
    }

    private function processPayment($order, $totalPrice)
    {
        // Integration with Chapa payment gateway
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_reference' => 'Chapa-Transaction-Ref',
            'payment_status' => 'completed',
            'amount' => $totalPrice,
        ]);

        return $payment;
    }
}
