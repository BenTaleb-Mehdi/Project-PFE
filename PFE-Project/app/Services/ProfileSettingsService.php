<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileSettingsService
{
    /**
     * Retrieve settings page data based on current user context.
     *
     * @return array
     */
    public function getSettingsData(): array
    {
        $user = Auth::user();
        $data = [
            'user' => $user
        ];

        if ($user && $user->hasRole('admin')) {
            $data['whatsappNumber'] = SystemSetting::getVal('whatsapp_number', '212600000000');
            $data['threshold'] = SystemSetting::getVal('deadline_alert_threshold', 2);
        }

        return $data;
    }

    /**
     * Update user profile information and admin configurations if applicable.
     *
     * @param array $validatedData
     * @return void
     */
    public function updateProfile(array $validatedData): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $user->update([
            'name'  => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        if ($user->hasRole('admin')) {
            if (isset($validatedData['whatsapp_number'])) {
                SystemSetting::setVal('whatsapp_number', $validatedData['whatsapp_number']);
            }
            if (isset($validatedData['deadline_alert_threshold'])) {
                SystemSetting::setVal('deadline_alert_threshold', $validatedData['deadline_alert_threshold']);
            }
        }
    }

    /**
     * Update user's password.
     *
     * @param string $newPassword
     * @return void
     */
    public function updatePassword(string $newPassword): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);
    }
}
