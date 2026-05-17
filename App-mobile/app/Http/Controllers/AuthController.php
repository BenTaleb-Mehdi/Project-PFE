<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('api_token')) {
            return redirect()->route('dashboard', ['id' => session('user_id')]);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        \Illuminate\Support\Facades\Log::info("Login attempt", $request->all());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = ApiHelper::postToApi('/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
            'device_name' => 'NativePHP_App'
        ]);

        if (!$response || !$response->successful()) {
            $message = 'Invalid credentials or connection error.';
            
            if ($response && $response->status() === 422) {
                return response()->json(['errors' => $response->json('errors')], 422);
            }

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 401);
            }

            return back()->withErrors(['email' => $message]);
        }

        $data = $response->json();
        
        session([
            'api_token' => $data['token'],
            'user_id' => $data['user']['id'],
            'user_name' => $data['user']['name'],
            'client_id' => $data['user']['client_id']
        ]);

        $id = $data['user']['client_id'] ?? $data['user']['id'];

        if ($request->wantsJson()) {
            return response()->json(['redirect' => route('dashboard', ['id' => $id])]);
        }

        return redirect()->route('dashboard', ['id' => $id]);
    }

    public function logout()
    {
        try {
            ApiHelper::postToApi('/auth/logout', []);
        } catch (\Exception $e) {
            // Ignore API logout errors and proceed with local logout
        }

        session()->flush();
        return redirect()->route('login');
    }
}
