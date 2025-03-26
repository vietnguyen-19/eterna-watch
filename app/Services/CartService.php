<?php

namespace App\Services;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function addToCart($variantId, $quantity = 1)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $quantity;
        } else {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $cart[$variantId] = [
                    'name' => $variant->name,
                    'price' => $variant->price,
                    'quantity' => $quantity
                ];
            }
        }

        Session::put('cart', $cart);
        return $cart;
    }

    public function getCart()
    {
        return Session::get('cart', []);
    }

    public function removeItem($variantId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
            Session::put('cart', $cart);
        }
    }

    public function clearCart()
    {
        Session::forget('cart');
    }
}
