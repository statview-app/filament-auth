<?php

namespace Statview\FilamentAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserOAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return [
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ];
    }
}