<?php

namespace App\Http\Controllers;

use ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ){}

    public function store(Request $request) {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone_number' => 'required|string|max:20',
            'postal_code' => 'required|string|max:10',
        ]);

        $this->contactService->create($validated);        

        return response()->json(['message' => 'Contact created successfully'], 201);

    }
}
