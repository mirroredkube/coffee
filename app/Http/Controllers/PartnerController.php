<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // Show the Partner Program Form
    public function show()
    {
        return view('partner'); // The view is partner.blade.php
    }

    // Handle Form Submission
    public function submit(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'business_contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'details' => 'required|string',
            'consent' => 'accepted',
        ]);

        // Process the form data (e.g., save to database, send email, etc.)
        // For demonstration, we are just returning a success message.
        // In real-world applications, you might send an email or store the data in the database.

        // Example: Mail::to('your-email@example.com')->send(new PartnerInquiryMail($validated));

        return redirect()->back()->with('success', 'Thank you for your interest in our B2B Partner Program. We will get in touch with you shortly.');
    }
}
