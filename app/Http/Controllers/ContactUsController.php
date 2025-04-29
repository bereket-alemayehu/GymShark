<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactusResource;
use App\Models\Contact;
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
        return ContactusResource::collection(Contact::all());
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
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // Create a new contact us message
        $contactUs = Contact::create($validated);

        // Return the created contact us message
        return response()->json([
            'data' => new ContactusResource($contactUs),
        ]);
    }
    
}
