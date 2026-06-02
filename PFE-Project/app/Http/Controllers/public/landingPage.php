<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Services\LandingPageService;
use App\Models\User;
use App\Models\Client;
use App\Models\Message;
use Illuminate\Http\Request;

class landingPage extends Controller
{
    protected $landingPageService;

    public function __construct(LandingPageService $landingPageService)
    {
        $this->landingPageService = $landingPageService;
    }

    public function index()
    {
        $data = $this->landingPageService->getLandingPageData();

        return view("landingpage", $data);
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'goal' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $goal = $request->input('goal') ?: 'General';
        $messageText = $request->input('message');

        // 1. Find or create the user as a client
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('Client@2026') // default temporary password
            ]);
            $user->assignRole('client');
        }

        // 2. Create the Client model/profile if it doesn't exist
        if (!$user->client) {
            Client::create([
                'user_id' => $user->id,
                'status' => 'Lead',
                'target_goal' => $goal,
            ]);
        }

        // 3. Find the admin user to receive the message
        $admin = User::role('admin')->first() ?: User::where('email', 'admin@ironcoach.com')->first();
        
        if ($admin) {
            Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $admin->id,
                'message' => "Contact Request - Goal: {$goal}\nMessage: {$messageText}",
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting us! We will get back to you soon.'
        ]);
    }
}
