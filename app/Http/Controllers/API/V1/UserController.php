<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Transaction;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function topUsers(): JsonResponse
    {
        $topUsers = Cache::remember('top_users', 30, function () {
            return $this->userService->getTopUsers();
        });

        return response()->json($topUsers);
    }
}
