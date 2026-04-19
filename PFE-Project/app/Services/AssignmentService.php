<?php

namespace App\Services;

use App\Models\Client;
use Carbon\Carbon;

class AssignmentService
{
    /**
     * Link a client to a specific program.
     */
    public function assignProtocol(int $clientId, int $programId, int $durationWeeks = 12)
    {
        $client = Client::findOrFail($clientId);
        
        return $client->update([
            'program_id'         => $programId,
            'program_started_at' => Carbon::now(),
            'duration_weeks'     => $durationWeeks,
        ]);
    }

    /**
     * Remove the current assignment.
     */
    public function removeProtocol(int $clientId)
    {
        $client = Client::findOrFail($clientId);
        
        return $client->update([
            'program_id'         => null,
            'program_started_at' => null,
        ]);
    }
}
