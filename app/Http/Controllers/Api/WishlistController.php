<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();
        return WishlistResource::collection($wishlists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return new WishlistResource($wishlist->load('product'));
    }    
    public function destroy(string $id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $wishlist->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}
