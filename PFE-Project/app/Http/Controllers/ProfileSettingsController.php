<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileSettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $data = [
            'user' => Auth::user()
        ];

        if (Auth::user()->hasRole('admin')) {
            $data['whatsappNumber'] = \App\Models\SystemSetting::getVal('whatsapp_number', '212600000000');
            $data['threshold'] = \App\Models\SystemSetting::getVal('deadline_alert_threshold', 2);
        }

        return view('profile.settings', $data);
    }

    /**
     * Update basic profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        if ($user->hasRole('admin')) {
            $rules['whatsapp_number'] = ['nullable', 'string', 'max:20'];
            $rules['deadline_alert_threshold'] = ['nullable', 'integer', 'min:0', 'max:30'];
        }

        $validated = $request->validate($rules);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->hasRole('admin')) {
            if (isset($validated['whatsapp_number'])) {
                \App\Models\SystemSetting::setVal('whatsapp_number', $validated['whatsapp_number']);
            }
            if (isset($validated['deadline_alert_threshold'])) {
                \App\Models\SystemSetting::setVal('deadline_alert_threshold', $validated['deadline_alert_threshold']);
            }
        }

        return back()->with('success', 'Profile information synchronized successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully. Security protocols updated.');
    }
}
