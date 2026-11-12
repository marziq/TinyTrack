<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::send([], [], function ($message) use ($validated) {
            $message->to('ammarhaziqzainal@gmail.com')
                    ->subject('New Contact Form Submission')
                    ->text("Name: {$validated['name']}\nEmail: {$validated['email']}\nMessage:\n{$validated['message']}");
        });


        return back()->with('success', 'Your message has been sent successfully!');
    }
}
