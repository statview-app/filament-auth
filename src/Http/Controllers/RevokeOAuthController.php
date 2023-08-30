<?php

namespace Statview\FilamentAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class RevokeOAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->user()->token();

        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($token->id);

        $refreshTokenRepository->revokeRefreshToken($token->id);
    }
}