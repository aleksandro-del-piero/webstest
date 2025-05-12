<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\UserAccessTokenRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PersonalAccessTokenController extends Controller
{
    /**
     * Create new token for user
     *
     * @param UserAccessTokenRequest $request
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(UserAccessTokenRequest $request, UserRepository $userRepository)
    {
        $dto = $request->getDto();

        $user = $userRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('validation.the_provided_credentials_are_incorrect'),
            ]);
        }

        return \App\Http\Response\Response::success([
            'token' => $user->createToken($dto->device_name)->plainTextToken
        ], status: Response::HTTP_CREATED);
    }

    /**
     * Logout user. Delete current api-token for user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return \App\Http\Response\Response::noContent();
    }
}
