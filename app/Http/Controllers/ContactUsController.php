<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Fetch all contact us messages
         return ContactUsResource::collection(ContactUs::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // Create a new contact us message
        $contactUs = ContactUs::create($validated);

        // Return the created contact us message
        return response()->json([
            'data' => new ContactUsResource($contactUs),
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
