<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request) {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone_number' => 'required|string|max:20',
            'postal_code' => 'required|string|max:10',
        ]);

        $contact = new Contact();
        $contact->name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->phone_number = $validated['phone_number'];
        $contact->postal_code = $validated['postal_code'];
        $contact->save();

        return response()->json(['message' => 'Contact created successfully'], 201);

    }
}
