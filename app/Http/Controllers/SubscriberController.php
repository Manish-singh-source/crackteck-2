<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    //
    public function index()
    {
        $subscriber = Subscriber::all();
        return view('/e-commerce/subscribers/index', compact('subscriber'));
    }

    public function sendMail()
    {
        return view('/e-commerce/subscribers/send-mail');
    }

    public function delete($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('subscriber.index')->with('success', 'Subscriber deleted successfully.');
    }

    public function sendMails(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);
        $subject = $request->subject;
        $body = $request->body;

        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            $email = $subscriber->email;
            // send mail

            // Mail::to($email)->send(new \App\Mail\SubscriberMail($subject, $body));
        }

        return redirect()->route('subscriber.index')->with('success', 'Mail sent successfully.');
    }

    /**
     * Handle newsletter subscription via AJAX
     */
    public function subscribe(Request $request)
    {
        // Validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already subscribed to our newsletter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        try {
            // Create new subscriber
            $subscriber = Subscriber::create([
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter! You will receive updates on our latest offers and products.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }
}
