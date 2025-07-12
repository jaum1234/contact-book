<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ){}

    public function store(Request $request) {
        Log::info('Incoming request to store contact', [
            'request' => $request->all()
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone_number' => 'required|string|max:20',
            'postal_code' => 'required|string|size:8|regex:/^\d{8}$/',
        ]);
        
        $this->contactService->create($validated);
        
        Log::info('Contact created successfully');
        
        return response()->json(['message' => 'Contact created successfully'], 201);
    }
}
