<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Response\Response;
use App\Repositories\UserRepository;

class RegisterController extends Controller
{
    /**
     * Register new user in system
     *
     * @param RegisterRequest $request
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request, UserRepository $userRepository)
    {
        $user = $userRepository->create($request->getDto());

        auth()->login($user);

        request()->session()->regenerate();

        return Response::success(['user' => UserResource::make($user)]);
    }
}
