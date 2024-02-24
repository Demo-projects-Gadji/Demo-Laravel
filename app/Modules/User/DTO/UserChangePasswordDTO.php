<?php

namespace App\Modules\User\DTO;

class UserChangePasswordDTO
{
    public function __construct(
        public string $email,
        public string $new_password
    )
    {
    }
}
