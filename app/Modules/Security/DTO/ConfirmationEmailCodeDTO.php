<?php

namespace App\Modules\Security\DTO;

class ConfirmationEmailCodeDTO
{
    public function __construct(
        public string $email,
        public string $code,
    ){}
}
