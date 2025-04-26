<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller{
    public function index(Request $request)
    {
        return Inertia::render('Account', [ 
            'title' => 'Account' 
        ]);
    }
}