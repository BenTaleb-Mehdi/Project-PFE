<?php

namespace App\Http\Controllers;

use App\Services\ClientProgramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientProgramController extends Controller
{
    public function __construct(
        private readonly ClientProgramService $clientProgramService
    ) {}

    public function show(int $id): JsonResponse
    {
        $data = $this->clientProgramService->getClientProgramData($id);

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
