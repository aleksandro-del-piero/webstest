<?php

namespace App\Dto\Api\Auth;

class PersonalAccessTokenDto
{
    public function __construct(public string $email, public string $password, public string $device_name)
    {
    }
}
