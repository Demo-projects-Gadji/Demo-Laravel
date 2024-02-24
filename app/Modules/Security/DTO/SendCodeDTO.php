<?php

namespace App\Modules\Security\DTO;

class SendCodeDTO
{
    public function __construct(
        public string $email,
    ){}
}
