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
            'request' => $request->except(['phone_number', 'email'])
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

    public function index(Request $request) {
        Log::info('Fetching contacts', [
            'filters' => $request->all()
        ]);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $contacts = $this->contactService->findAll($validated);

        Log::info('Contacts fetched successfully', [
            'count' => count($contacts)
        ]);

        return response()->json([
            'message' => 'Contacts fetched successfully',
            'data' => $contacts->items(),
            'pagination' => [
                'total_items' => $contacts->total(),
                'total_pages' => $contacts->lastPage(),
                'current_page' => $contacts->currentPage(),
                'per_page' => $contacts->perPage(),
                'next_page' => $contacts->nextPageUrl(),
                'prev_page' => $contacts->previousPageUrl(),
            ]
        ]);
    }
}
