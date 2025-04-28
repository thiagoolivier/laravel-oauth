<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function linkedAccounts(Request $request)
    {
        return Inertia::render('account/LinkedAccounts', [
            'title' => 'Linked Accounts'
        ]);
    }

    public function getLinkedAccounts(Request $request): JsonResponse
    {
        return response()->json($request->user()->socialAccounts);
    }
}