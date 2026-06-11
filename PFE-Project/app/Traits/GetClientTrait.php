<?php

namespace App\Traits;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;

trait GetClientTrait
{
    private function getClient(): Client
    {
        if ($clientId = request('client_id')) {
            return Client::find($clientId) ?? Client::first();
        }

        $user = Auth::user();
        $client = $user ? $user->client : Client::first();

        if (!$client) {
            abort(404, 'DEPLOYMENT_ERROR: No Client context found.');
        }

        return $client;
    }
}
