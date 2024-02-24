<?php

namespace App\Modules\User\DTO;

class UserUpdateDTO
{
    public function __construct(
        public string $user_token,
        public ?string $username,
        public ?string $avatar,
        public ?string $link,
        public ?string $date_birth,
        public ?string $pol,
        public ?string $description,
        public ?string $name,
        public ?string $surname,
        public ?string $email,
        public ?string $private,
        public ?array $entrypoint,
        public ?array $token_notification,
    ){}
}
