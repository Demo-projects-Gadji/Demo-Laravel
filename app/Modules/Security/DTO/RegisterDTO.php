<?php

namespace App\Modules\Security\DTO;

class RegisterDTO
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
    ){}
}
