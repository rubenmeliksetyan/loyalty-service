<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\AccountRequest;
use App\Interfaces\Services\IAccountService;
use App\Models\LoyaltyAccount;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Account\CreateRequest;

class AccountController extends Controller
{
    public function create(CreateRequest $request, IAccountService $service): LoyaltyAccount
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

    public function activate(AccountRequest $request, IAccountService $service): JsonResponse
    {
        $service->changeStatusAndNotify(
            $request->input('type'),
            $request->input('id'),
            true
        );
        return response()->json(['success' => true]);
    }

    public function deactivate(AccountRequest $request, IAccountService $service): JsonResponse
    {
        $service->changeStatusAndNotify(
            $request->input('type'),
            $request->input('id'),
            false
        );
        return response()->json(['success' => true]);
    }

    public function balance(AccountRequest $request, IAccountService $service): JsonResponse
    {
        return response()->json([
            'balance' => $service->getBalance($request->input('type'),
            $request->input('id'))
        ]);
    }
}
