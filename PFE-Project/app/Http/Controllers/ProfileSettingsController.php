<?php

namespace App\Http\Controllers;

use App\Services\ProfileSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileSettingsController extends Controller
{
    /**
     * The profile settings service instance.
     *
     * @var ProfileSettingsService
     */
    protected $profileSettingsService;

    /**
     * Create a new controller instance.
     *
     * @param ProfileSettingsService $profileSettingsService
     */
    public function __construct(ProfileSettingsService $profileSettingsService)
    {
        $this->profileSettingsService = $profileSettingsService;
    }

    /**
     * Display the settings page.
     */
    public function index()
    {
        $data = $this->profileSettingsService->getSettingsData();

        return view('profile.settings', $data);
    }

    /**
     * Update basic profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'User context not found.');
        }

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        if ($user->hasRole('admin')) {
            $rules['whatsapp_number'] = ['nullable', 'string', 'max:20'];
            $rules['deadline_alert_threshold'] = ['nullable', 'integer', 'min:0', 'max:30'];
        }

        $validated = $request->validate($rules);

        $this->profileSettingsService->updateProfile($validated);

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

        $this->profileSettingsService->updatePassword($validated['password']);

        return back()->with('success', 'Password updated successfully. Security protocols updated.');
    }
}
