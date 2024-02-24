<?php

namespace App\Modules\Security\DTO;

use App\Modules\Security\Resources\AuthUserResource;
use App\Models\User;

class UserDTO
{
    public function __construct(private readonly ?User $user, private readonly ?string $token){;}

    public function getUser(): AuthUserResource|array
    {
        if(empty($this->user)) return [];
        return new AuthUserResource($this->user);
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

}
