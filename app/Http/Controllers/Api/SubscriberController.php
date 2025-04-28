<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subscribers = Subscriber::all();
        return SubscriberResource::collection($subscribers);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers',
        ]);

        Subscriber::create([
            'email' => $validated['email'],
        ]);

        return response()->json([
            'data' => new SubscriberResource(Subscriber::firstWhere('email', $validated['email'])),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
