<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\IAccountService;
use App\Models\LoyaltyAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create(Request $request, IAccountService $service): LoyaltyAccount
    {
        return $service->create(
            $request->only([
                'phone',
                'card',
                'email',
                'email_notification',
                'phone_notification'
            ])
        );
    }

    public function activate(string $type, string $id, IAccountService $service): JsonResponse
    {
        $service->changeStatusAndNotify($type, $id, true);
        return response()->json(['success' => true]);
    }

    public function deactivate(string $type, string $id, IAccountService $service): JsonResponse
    {
        $service->changeStatusAndNotify($type, $id, false);
        return response()->json(['success' => true]);
    }

    public function balance(string $type, string $id, IAccountService $service): JsonResponse
    {
        return response()->json(['balance' => $service->getBalance($type, $id)]);
    }
}
